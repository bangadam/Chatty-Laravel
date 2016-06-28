<?php

namespace Chatty\Http\Controllers;

use Auth;
use Chatty\Models\User;
use Illuminate\Http\Request;


class FriendController extends Controller
{
  public function getIndex()
  {
    $friends = Auth::user()->friends();
    $request = Auth::user()->FriendsRequest();

    return view('friend.index')
                ->with('friends', $friends)
                ->with('request', $request);
  }

  public function getAdd($username)
  {
    $user = User::where('username', $username)->first();

    if (!$user) {
      return redirect()
          ->route('home')
          ->with('info', 'Maaf User yang anda cari tidak ada.');
        }

    if (Auth::user()->id === $user->id) {
        return redirect()->route('home');
        }

    if (Auth::user()->hasFriendsRequestPending($user) ||
        $user->hasFriendsRequestPending(Auth::user()))  {
        return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'permintaan pertemanan menunggu konfirmasi.');
        }
    if (Auth::user()->isFriendsWith($user)) {
      return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'Kamu Sudah berteman.');
      }
    Auth::user()->AddFriends($user);
    return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'Permintaan Pertemanan Sudah terkirim.');
  }

  public function getAccept($username){
    $user = User::where('username', $username)->first();

    if (!$user) {
      return redirect()
          ->route('home')
          ->with('info', 'Maaf user yang anda cari tidak ada');
    }

    if (!Auth::user()->hasFriendsRequestRecevied($user)) {
      return redirect()->route('home');
    }

    Auth::user()->AcceptFriendsRequest($user);

    return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'permintaan pertemanan diterima');
  }

  public function postDelete($username){
    $user = User::where('username', $username)->first();

    if (!Auth::user()->isFriendsWith($user)) {
      return redirect()->back();
    }

    Auth::user()->deleteFriend($user);
    return redirect()->back()->with('info', 'Pertemanan berhasil dihapus !');
  }
}
