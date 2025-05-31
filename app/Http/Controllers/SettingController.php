<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Social;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showSettings()
    {
        $appName = Setting::getValue('app_name');
        $logo = Setting::getValue('logo');
//        dd($logo);
        $socials = Social::all();
        return view('settings', [
            'app_name' => $appName,
            'logo' => $logo,
            'socials' => $socials,
        ]);
    }

    public function updateSettings(Request $request): \Illuminate\Http\RedirectResponse
    {
        Setting::setValue('app_name', $request->input('app_name'));

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            Setting::setValue('logo', $path);
        }

        if ($request->has('social_links')) {
            $socialLinks = $request->input('social_links');

            Social::query()->delete();
            foreach ($socialLinks as $socialLink)
            {
                Social::setSocials($socialLink['name'], $socialLink['url']);
            }

        }

        return redirect()->back()->with('success', 'Settings updated.');
    }

    public function addNewSocial(Request $request)
    {
        $social = new Social();
        $social->name = $request->input('name');
        $social->url = $request->input('url');
        $social->save();

        return redirect()->back()->with('success', 'Socials Added.');

    }
}
