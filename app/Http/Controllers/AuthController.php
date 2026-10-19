<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PlantOutput;
use App\Models\EnergySale;
use App\Models\HrCount;
use App\Models\Organization;

class AuthController extends Controller
{
    // Login form үзүүлэх
    public function showLoginForm()
    {
        return view('login')->withErrors([]);
    }

    // Login үйлдэл
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Хэрэглэгчийн нэр эсвэл нууц үг буруу байна.',
            ])->onlyInput('username');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    // Dashboard view
    public function dashboard(Request $request)
    {
        $user        = Auth::user();
        $currentYear  = (int) date('Y');
        $currentMonth = (int) date('n');

        // Өмнөх сар тооцоолох
        $prevMonth = $currentMonth === 1 ? 12 : $currentMonth - 1;
        $prevYear  = $currentMonth === 1 ? $currentYear - 1 : $currentYear;

        // Admin: байгууллагын мэдээ бөглөлтийн хяналт (өмнөх сарын)
        $orgStats = null;
        if ($user->role?->name === 'admin') {
            $allOrgs = Organization::orderBy('org_name')->get();

            $outputSubmittedOrgIds = PlantOutput::where('year', $prevYear)
                ->where('month', $prevMonth)
                ->whereNotNull('org_id')
                ->pluck('org_id')->unique();

            $salesSubmittedOrgIds = EnergySale::where('year', $prevYear)
                ->where('month', $prevMonth)
                ->whereNotNull('org_id')
                ->pluck('org_id')->unique();

            $orgStats = [
                'total'   => $allOrgs->count(),
                'month'   => $prevMonth,
                'year'    => $prevYear,
                'output'  => [
                    'submitted'     => $allOrgs->whereIn('id', $outputSubmittedOrgIds),
                    'not_submitted' => $allOrgs->whereNotIn('id', $outputSubmittedOrgIds),
                ],
                'sales'   => [
                    'submitted'     => $allOrgs->whereIn('id', $salesSubmittedOrgIds),
                    'not_submitted' => $allOrgs->whereNotIn('id', $salesSubmittedOrgIds),
                ],
            ];
        }

        // User: өөрийн байгууллагын мэдээнүүд
        $userStats = null;
        if ($user->role?->name !== 'admin' && $user->org_id) {
            $orgId = $user->org_id;

            $hrAll = HrCount::where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

            $outputAll = PlantOutput::with('powerPlant')
                ->where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

            $salesAll = EnergySale::with('powerPlant')
                ->where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

            // Сар бүрийн түлхүүр: "2026-03"
            $periodKey = fn ($r) => sprintf('%04d-%02d', (int) $r->year, (int) $r->month);

            // Бүх мэдээнээс сарын жагсаалт (шинэ нь эхэнд)
            $allRecords = collect()->merge($hrAll)->merge($outputAll)->merge($salesAll);
            $periods = $allRecords
                ->map(fn ($r) => ['key' => $periodKey($r), 'year' => (int) $r->year, 'month' => (int) $r->month])
                ->unique('key')
                ->sortByDesc('key')
                ->values()
                ->map(fn ($p) => $p + ['label' => "{$p['year']} он {$p['month']} сар"]);

            // Хамгийн сүүлд оруулсан мэдээ (created_at-аар) → тэр мэдээний сар
            $latestRecord = $allRecords->sortByDesc('created_at')->first();
            $latestKey    = $latestRecord ? $periodKey($latestRecord) : null;
            $latestLabel  = $periods->firstWhere('key', $latestKey)['label'] ?? null;

            // Шүүлтүүр: ?period=2026-03 эсвэл ?period=all. Үгүй бол сүүлд оруулсан сар.
            $requested = $request->query('period');
            if ($requested === 'all' || $periods->contains('key', $requested)) {
                $selectedPeriod = $requested;
            } else {
                $selectedPeriod = $latestKey ?? 'all';
            }

            $filterByPeriod = fn ($items) => $selectedPeriod === 'all'
                ? $items
                : $items->filter(fn ($r) => $periodKey($r) === $selectedPeriod)->values();

            // Хүний нөөцийн хамгийн сүүлийн сарын мэдээний тоо (нийлбэр биш)
            $hrLastRecord = $hrAll->last();
            $hrLatest = $hrLastRecord ? [
                'label' => "{$hrLastRecord->year} он {$hrLastRecord->month} сар",
                'count' => $hrAll->filter(fn ($r) => $periodKey($r) === $periodKey($hrLastRecord))->count(),
            ] : null;

            $hrRecords     = $filterByPeriod($hrAll);
            $outputRecords = $filterByPeriod($outputAll);
            $salesRecords  = $filterByPeriod($salesAll);

            // Анхааруулга: тухайн сарын 5-ны дотор өмнөх сарын мэдээ оруулах
            $currentDay  = (int) date('j');
            $showWarning = $currentDay <= 5;
            $warnMonth   = $prevMonth;
            $warnYear    = $prevYear;

            // Өмнөх сарын мэдээ бүртгэгдсэн эсэх
            $hasOutput = PlantOutput::where('org_id', $orgId)
                ->where('year', $prevYear)->where('month', $prevMonth)->exists();
            $hasSales  = EnergySale::where('org_id', $orgId)
                ->where('year', $prevYear)->where('month', $prevMonth)->exists();
            $hasHr     = HrCount::where('org_id', $orgId)
                ->where('year', $prevYear)->where('month', $prevMonth)->exists();

            $userStats = compact(
                'hrRecords', 'outputRecords', 'salesRecords',
                'showWarning', 'warnMonth', 'warnYear',
                'hasOutput', 'hasSales', 'hasHr', 'currentDay',
                'periods', 'selectedPeriod', 'latestKey', 'latestLabel', 'hrLatest'
            );
        }

        return view('dashboard', compact('currentYear', 'currentMonth', 'orgStats', 'userStats'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}