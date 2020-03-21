<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('verified')->except(['profile', 'update']);
    }

    /**
     * Show the users' dashboard (i.e. Home).
     *
     * @return Renderable
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Show the user profile
     *
     * @return View
     * @throws ModelNotFoundException
     */
    public function profile()
    {
        $user = User::with('profile')->findOrFail(auth()->user()->id);

        return view('users.profile', compact('user'));
    }

    /**
     * Update the user's profile
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:128',
            //'language' => 'required|max:2',
            'currency' => 'required|max:3'
        ]);
        $requestData = $request->all();

        $collection      = collect($requestData);
        $userRequestData = $collection->filter(static function ($value, $key) {
            return in_array($key, (new User())->getFillable(), true);
        });

        $user->update($userRequestData->all());

        $collectionP        = collect($requestData);
        $profileRequestData = $collectionP->filter(static function ($value, $key) {
            return in_array($key, (new UserProfile())->getFillable(), true);
        });

        $user->profile()->update($profileRequestData->all());

        return redirect('profile')->with('success', 'Profile successfully updated!');
    }

    /**
     * Show the user preferences
     *
     * @param string $setting
     *
     * @return View
     */
    public function preferences(string $setting = 'dashboard.clock')
    {
        // Show a 404 if the given setting doesn't match the format
        if (!$this->isValidSettingName($setting)) {
            return abort(404);
        }

        [$component, $part] = explode('.', $setting);

        return view(
            'users.preferences.' . str_replace('.', '_', $setting),
            [
                'component'   => $component,
                'part'        => $part,
                'index'       => $this->getPreferencesIndex(),
                'preferences' => auth()->user()->profile->preferences[$component] ?? []
            ]
        );
    }

    /**
     * Validate the given setting string
     *
     * @param string $setting
     * @return bool
     */
    private function isValidSettingName(string $setting)
    {
        if (!strpos($setting, '.')) {
            return false;
        }

        return true;
    }

    /**
     * Get the index (navigation) for the Preferences page(s)
     *
     * @return array
     */
    private function getPreferencesIndex(): array
    {
        return [
            'volta' => [
                'name'    => __('preferences.components.volta'),
                'enabled' => false,
                'parts'   => [
                    'main' => [
                        'url'  => '/preferences/volta.main',
                        'name' => 'General'
                    ]
                ]
            ],
            'dashboard' => [
                'name'    => __('preferences.components.dashboard'),
                'enabled' => true,
                'parts'   => [
                    'clock' => [
                        'url'  => '/preferences/dashboard.clock',
                        'name' => __('preferences.clock.name')
                    ],
                    'weather' => [
                        'url'  => '/preferences/dashboard.weather',
                        'name' => __('preferences.weather.name')
                    ]
                ]
            ]
        ];
    }

    /**
     * Update the user's preferences.
     *
     * @param Request $request
     * @param string $setting
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updatePreferences(Request $request, string $setting)
    {
        // Show a 404 if the given setting doesn't match the format
        if (!$this->isValidSettingName($setting)) {
            return abort(404);
        }

        [$component, $part] = explode('.', $setting);

        $className = '\App\Http\Requests\\' . ucfirst($component) . ucfirst($part) . 'Preferences';

        $validatedData = $this->validate($request, (new $className())->rules());

        $preferences = auth()->user()->profile->preferences;

        foreach ($validatedData as $key => $value) {
            $preferences[$component][$part][$key] = $value;
        }

        auth()->user()->profile()->update(['preferences' => json_encode($preferences)]);

        return redirect()->back()->with('success', 'Preferences successfully updated!');
    }
}
