<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $totalContacts = Contact::where('user_id', $userId)->count();
        $favoriteCount = Contact::where('user_id', $userId)->where('is_favorite', true)->count();
        $recentContacts = Contact::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get(['id','first_name','last_name','email','phone','city','created_at','birthday','photo_path']);

        $favoriteContacts = Contact::where('user_id', $userId)
            ->where('is_favorite', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit(8)
            ->get(['id','first_name','last_name','email','phone','city','photo_path']);

        return view('dashboard.index', compact('totalContacts', 'favoriteCount', 'recentContacts', 'favoriteContacts'));
    }
}
