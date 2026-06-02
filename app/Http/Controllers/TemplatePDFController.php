<?php

namespace App\Http\Controllers;

use App\Models\TemplatePDF;
use Illuminate\Http\Request;

class TemplatePDFController extends Controller
{
    public function edit()
    {
        $template = TemplatePDF::where('status', 'active')->first() ?? TemplatePDF::first();

        $listTemplates = TemplatePDF::all();

        return view('template_pdf.edit', compact('template', 'listTemplates'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:template_pdfs,id',
        ]);

        // 1. Matikan semua status active terlebih dahulu
        TemplatePDF::where('status', 'active')->update(['status' => 'non-active']);

        // 2. Update data template yang dipilih dan set jadi active
        $template = TemplatePDF::findOrFail($request->id);
        $template->update([
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Template ' . $template->company_name . ' berhasil diupdate dan diaktifkan!');
    }

}
