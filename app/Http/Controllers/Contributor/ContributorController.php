<?php 
namespace App\Http\Controllers\Contributor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ContributorInterface;

class ContributorController extends Controller
{

    public function __construct(protected ContributorInterface $contributorService)
    {
       
    }

    public function store(Request $request)
    {
        try {
            $contributor = $this->contributorService->create($request);
            return redirect()->back()->with('success', 'Contributor created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update(Request $request)
    {
        try {
            $contributor = $this->contributorService->update($request);

            return redirect()->back()->with('success', 'Contributor profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}