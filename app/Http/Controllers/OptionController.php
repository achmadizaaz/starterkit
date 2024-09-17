<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller
{
    protected $model, $modelRole;
    public function __construct(Option $model, Role $modelRole)
    {
        $this->model = $model;
        $this->modelRole = $modelRole;
    }

    public function index()
    {
        $option = $this->model->get();
        return view('options.index', [
            'option'=> $option->keyBy('name'),
            'roles'  => $this->modelRole->whereNotIn('name', ['Super Administrator'])->get(),
        ]);
    }

    public function update(OptionRequest $request)
    {
        $option =  $this->model->get();
        $data = $option->keyBy('name');
        // Insert file image favicon
        $pathFavicon = $data['favicon']->value;
        if(isset($request->favicon)){
            $faviconWithExt = $request->file('favicon')->getClientOriginalName();
            $faviconToStore = time().'-'.$faviconWithExt;
            $pathFavicon = $request->file('favicon')->storeAs('options', $faviconToStore, 'public');

            // Remove old image
            if(isset($data['favicon']->value)){
                Storage::disk('public')->delete($data['favicon']->value);
            }
        }

        // Insert file image sidebar icon
        $pathSidebarIcon = $data['sidebar-icon']->value;
        if(isset($request->sidebarIcon)){
            $sidebarIconWithExt = $request->file('sidebarIcon')->getClientOriginalName();
            $sidebarIconToStore = time().'-'.$sidebarIconWithExt;
            $pathSidebarIcon = $request->file('sidebarIcon')->storeAs('options', $sidebarIconToStore, 'public');
            
            // Remove old image
            if(isset($data['sidebar-icon']->value)){
                Storage::disk('public')->delete($data['sidebar-icon']->value);
            }
        }

        // Update options
        $this->model->upsert([
            ['name' => 'site-title', 'value'=> $request->siteTitle],
            ['name' => 'favicon', 'value' => $pathFavicon],
            ['name' => 'address', 'value' => $request->address],
            ['name' => 'contact', 'value' => $request->contact],

            ['name' => 'sidebar-icon', 'value' => $pathSidebarIcon],
            ['name' => 'sidebar-text-icon', 'value' => $request->sidebarTextIcon],

            ['name' => 'can-register', 'value' => $request->canRegister == 'on' ? 'yes' : 'no'],
            ['name' => 'default-role', 'value' => $request->defaultRole],
            ['name' => 'default-is-active', 'value' => $request->isActive],
            ['name' => 'can-forget-password', 'value' => $request->canForgetPassword == 'on' ? 'yes' : 'no'],
        ], uniqueBy: ['name'], update: ['value']);

        return back()->with('success', 'options updated successfully');
    }
}
