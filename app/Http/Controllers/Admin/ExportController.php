<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\VisitorCounter;
use App\Models\ForumReply;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportController extends Controller
{
    public function exportFullReport()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);

            // 1. SHEET FORUM
            $this->addForumSheet($spreadsheet);

            // 2. SHEET TESTIMONI
            $this->addTestimonialSheet($spreadsheet);

            // 3. SHEET BALASAN FORUM
            $this->addForumReplySheet($spreadsheet);

            // 4. SHEET RINGKASAN (tanpa data chart)
            $this->addSummarySheet($spreadsheet);

            $spreadsheet->setActiveSheetIndex(0);

            $filename = 'laporan_waluyaland_' . date('Y-m-d_H-i-s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function addForumSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Forum');

        $forums = Contact::where('type', 'forum')->orderBy('created_at', 'desc')->get();
        $headers = ['ID', 'Nama', 'Email', 'Institusi', 'Pesan', 'Status', 'Disetujui Pada', 'Catatan Admin', 'Dibuat Pada'];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E7D32']],
        ]);

        $row = 2;
        foreach ($forums as $forum) {
            $sheet->setCellValue('A' . $row, $forum->id);
            $sheet->setCellValue('B' . $row, $forum->name);
            $sheet->setCellValue('C' . $row, $forum->email);
            $sheet->setCellValue('D' . $row, $forum->institution ?? '-');
            $sheet->setCellValue('E' . $row, $forum->message);
            $sheet->setCellValue('F' . $row, $forum->status);
            $sheet->setCellValue('G' . $row, $forum->approved_at ?? '-');
            $sheet->setCellValue('H' . $row, $forum->admin_notes ?? '-');
            $sheet->setCellValue('I' . $row, $forum->created_at);
            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function addTestimonialSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Testimoni');

        $testimonials = Contact::where('type', 'testimonial')->orderBy('created_at', 'desc')->get();
        $headers = ['ID', 'Nama', 'Email', 'Institusi', 'Testimoni', 'Status', 'Disetujui Pada', 'Catatan Admin', 'Dibuat Pada'];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9A825']],
        ]);

        $row = 2;
        foreach ($testimonials as $testimonial) {
            $sheet->setCellValue('A' . $row, $testimonial->id);
            $sheet->setCellValue('B' . $row, $testimonial->name);
            $sheet->setCellValue('C' . $row, $testimonial->email);
            $sheet->setCellValue('D' . $row, $testimonial->institution ?? '-');
            $sheet->setCellValue('E' . $row, $testimonial->message);
            $sheet->setCellValue('F' . $row, $testimonial->status);
            $sheet->setCellValue('G' . $row, $testimonial->approved_at ?? '-');
            $sheet->setCellValue('H' . $row, $testimonial->admin_notes ?? '-');
            $sheet->setCellValue('I' . $row, $testimonial->created_at);
            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function addForumReplySheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Balasan Forum');

        $replies = ForumReply::with('contact')->orderBy('created_at', 'desc')->get();
        $headers = ['ID', 'ID Forum', 'Nama Forum', 'Nama Pengirim', 'Email', 'Balasan', 'Status', 'Dibuat Pada'];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1565C0']],
        ]);

        $row = 2;
        foreach ($replies as $reply) {
            $sheet->setCellValue('A' . $row, $reply->id);
            $sheet->setCellValue('B' . $row, $reply->contact_id);
            $sheet->setCellValue('C' . $row, $reply->contact->name ?? '-');
            $sheet->setCellValue('D' . $row, $reply->name);
            $sheet->setCellValue('E' . $row, $reply->email);
            $sheet->setCellValue('F' . $row, $reply->message);
            $sheet->setCellValue('G' . $row, $reply->status);
            $sheet->setCellValue('H' . $row, $reply->created_at);
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function addSummarySheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Ringkasan');

        $sheet->setCellValue('A1', '📋 RINGKASAN LAPORAN WALUYA LAND');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '2E7D32']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Item');
        $sheet->setCellValue('C3', 'Jumlah');

        $sheet->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E7D32']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        $summaryData = [
            ['Tanggal Laporan', date('d/m/Y H:i:s')],
            ['Total Forum', Contact::where('type', 'forum')->count()],
            ['Total Testimoni', Contact::where('type', 'testimonial')->count()],
            ['Total Balasan Forum', ForumReply::count()],
            ['Total Pengunjung (Keseluruhan)', VisitorCounter::sum('count')],
            ['Rata-rata Pengunjung per Hari', round(VisitorCounter::avg('count'))],
        ];

        $row = 4;
        $no = 1;
        foreach ($summaryData as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item[0]);
            $sheet->setCellValue('C' . $row, $item[1]);
            $row++;
            $no++;
        }

        $sheet->getStyle('A3:C' . ($row-1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A4:A' . ($row-1))->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(25);
    }
}
