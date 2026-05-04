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
    public function dashboard()
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

            $hrRecords = HrCount::where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

            $outputRecords = PlantOutput::with('powerPlant')
                ->where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

            $salesRecords = EnergySale::with('powerPlant')
                ->where('org_id', $orgId)
                ->orderBy('year')->orderBy('month')->get();

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
                'hasOutput', 'hasSales', 'hasHr', 'currentDay'
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