<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Repository\ContractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;

/**
 * @Route("/export")
 */
class ExportController extends AbstractController
{
    /**
     * @Route("/export", name="export_app")
     */
    public function exportPdf(EntityManagerInterface $entityManager,Request $request, Pdf $pdf): Response
    {
        $contract = $entityManager->getRepository(Contract::class)->find($request->query->get('contratid'));

        $pdf->setBinary('"../src/Wkhtmltopdf/bin/wkhtmltopdf.exe"'); //TODO supprime pute
        $pdf->setTemporaryFolder("../var/cache");

        $html = $this->renderView(
            'export/export.html.twig',
            array(
                'controller_name' => 'BackofficeController',
                'contrat' => $contract
            )
        );
        $response = new PdfResponse(
            $pdf->getOutputFromHtml($html),
            'contrat_'.$contract->getNumContrat().'.pdf'
        );
        $pdf->removeTemporaryFiles();
        return $response;
    }

    /**
     * @Route("/export-selection",name="export_selection")
     */
    public function exportSelection(Request $request, Pdf $pdf, ContractRepository $contractRepository){
        $numContracts = json_decode($request->getContent(),true)["contracts"];
        $pdf->setTemporaryFolder("../var/cache");
        $filename = $pdf->getTemporaryFolder()."/contrats_export.zip";
        $zip = new ZipArchive();
        if (file_exists($filename)){
            unlink($filename);
        }
        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("Impossible d'ouvrir le fichier <$filename>\n");
        }

        foreach ($numContracts as $key=>$numContract){
            $contract = $contractRepository->findOneBy(['num_contrat'=>$numContract['_values']['list-numcontrat']]);
            $html = $this->renderView(
                'export/export.html.twig',
                array(
                    'controller_name' => 'BackofficeController',
                    'contrat' => $contract
                )
            );
            $pdf->generateFromHtml(
                $html,
                $pdf->getTemporaryFolder().'/temp_pdf/contrat_'.$contract->getNumContrat().'.pdf'
            );
            $zip->addFile($pdf->getTemporaryFolder().'/temp_pdf/contrat_'.$contract->getNumContrat().'.pdf','contrat_'.$contract->getNumContrat().'.pdf');
        }
        $zip->close();
        $pdf->removeTemporaryFiles();
        $this->removeDir($pdf->getTemporaryFolder().'/temp_pdf');
        return $this->file($filename);
    }

    /**
     * @Route("/export-selection-xlsx", name="export_selection_xlsx")
     */
    public function exportSelectionXlsx(EntityManagerInterface $entityManager,Request $request, ContractRepository $contractRepository)
    {
        $numContracts = json_decode($request->getContent(),true)["contracts"];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = '../var/cache/contrats_export.xlsx';

        $sheet->setTitle('Contrats Stark industries');
        $sheet->getCell('A1')->setValue('Numéro de contrat');
        $sheet->getCell('B1')->setValue('Commercial');
        $sheet->getCell('C1')->setValue('Distributeur');
        $sheet->getCell('D1')->setValue('Client');
        $sheet->getCell('E1')->setValue('Adresse');
        $sheet->getCell('F1')->setValue('Code postal');
        $sheet->getCell('G1')->setValue('Ville');
        $sheet->getCell('H1')->setValue('Numéro de téléphone');
        $sheet->getCell('I1')->setValue('Mail');
        $sheet->getCell('J1')->setValue('Date de signature');
        $sheet->getCell('K1')->setValue('Status du contrat');
        $sheet->getCell('L1')->setValue('RIB');
        $sheet->getCell('M1')->setValue('BIC');

        $data = [];
        foreach ($numContracts as $key=>$numContract){
            $contract = $contractRepository->findOneBy(['num_contrat'=>$numContract['_values']['list-numcontrat']]);

            switch ($contract->getStatus()){
                case '1':
                    $status = 'En attente client';
                    break;
                case '2':
                    $status = 'En attente back-office';
                    break;
                case '3':
                    $status = 'Validé';
                    break;
                case '4':
                    $status = 'Rétracté';
                    break;
                case '5':
                    $status = 'Injoignable';
                    break;
                case '6':
                    $status = 'Impayé';
                    break;
                default:
                    $status = 'Erreur';
                    break;
            }
            $data[] = [
                $contract->getNumContrat(),
                $contract->getSalesman()->getFirstname().' '.$contract->getSalesman()->getName(),
                $contract->getSalesman()->getDistributor()->getName(),
                (($contract->getInfoClient()['gender'] == 'm')?'M.':'Mme').' '.$contract->getInfoClient()['firstname'].' '.$contract->getInfoClient()['lastname'],
                $contract->getInfoClient()['address'],
                $contract->getInfoClient()['zipcode'],
                $contract->getInfoClient()['city'],
                $contract->getInfoClient()['mobile'],
                $contract->getInfoClient()['mail'],
                $contract->getCreated(),
                $status,
                $contract->getInfoPrelevement()['iban'],
                $contract->getInfoPrelevement()['bic'],
            ];
        }

        $sheet->fromArray($data,' - ','A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $this->file($filename);
    }

    /**
     * @Route("/export-all", name="export_all")
     */
    public function exportAllPdf(EntityManagerInterface $entityManager,Request $request, Pdf $pdf)
    {
        $contracts = $entityManager->getRepository(Contract::class)->findAll();
        $pdf->setTemporaryFolder("../var/cache");
        $filename = $pdf->getTemporaryFolder()."/contrats_export.zip";
        $zip = new ZipArchive();
        if (file_exists($filename)){
            unlink($filename);
        }
        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("Impossible d'ouvrir le fichier <$filename>\n");
        }

        foreach ($contracts as $key=>$contract){
            $html = $this->renderView(
                'export/export.html.twig',
                array(
                    'controller_name' => 'BackofficeController',
                    'contrat' => $contract
                )
            );
            $pdf->generateFromHtml(
                $html,
                $pdf->getTemporaryFolder().'/temp_pdf/contrat_'.$contract->getNumContrat().'.pdf'
            );
            $zip->addFile($pdf->getTemporaryFolder().'/temp_pdf/contrat_'.$contract->getNumContrat().'.pdf','contrat_'.$contract->getNumContrat().'.pdf');
        }
        $zip->close();
        $pdf->removeTemporaryFiles();
        $this->removeDir($pdf->getTemporaryFolder().'/temp_pdf');
        return $this->file($filename);
    }

    /**
     * @Route("/export-all-xlsx", name="export_all_xlsx")
     */
    public function exportAllXlsx(EntityManagerInterface $entityManager,Request $request)
    {
        $contracts = $entityManager->getRepository(Contract::class)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = '../var/cache/contrats_export.xlsx';

        $sheet->setTitle('Contrats Stark industries');
        $sheet->getCell('A1')->setValue('Numéro de contrat');
        $sheet->getCell('B1')->setValue('Commercial');
        $sheet->getCell('C1')->setValue('Distributeur');
        $sheet->getCell('D1')->setValue('Client');
        $sheet->getCell('E1')->setValue('Adresse');
        $sheet->getCell('F1')->setValue('Code postal');
        $sheet->getCell('G1')->setValue('Ville');
        $sheet->getCell('H1')->setValue('Numéro de téléphone');
        $sheet->getCell('I1')->setValue('Mail');
        $sheet->getCell('J1')->setValue('Date de signature');
        $sheet->getCell('K1')->setValue('Status du contrat');
        $sheet->getCell('L1')->setValue('RIB');
        $sheet->getCell('M1')->setValue('BIC');

        $data = [];
        foreach ($contracts as $key=>$contract){
            switch ($contract->getStatus()){
                case '1':
                    $status = 'En attente client';
                    break;
                case '2':
                    $status = 'En attente back-office';
                    break;
                case '3':
                    $status = 'Validé';
                    break;
                case '4':
                    $status = 'Rétracté';
                    break;
                case '5':
                    $status = 'Injoignable';
                    break;
                case '6':
                    $status = 'Impayé';
                    break;
                default:
                    $status = 'Erreur';
                    break;
            }
            $data[] = [
                $contract->getNumContrat(),
                $contract->getSalesman()->getFirstname().' '.$contract->getSalesman()->getName(),
                $contract->getSalesman()->getDistributor()->getName(),
                (($contract->getInfoClient()['gender'] == 'm')?'M.':'Mme').' '.$contract->getInfoClient()['firstname'].' '.$contract->getInfoClient()['lastname'],
                $contract->getInfoClient()['address'],
                $contract->getInfoClient()['zipcode'],
                $contract->getInfoClient()['city'],
                $contract->getInfoClient()['mobile'],
                $contract->getInfoClient()['mail'],
                $contract->getCreated(),
                $status,
                $contract->getInfoPrelevement()['iban'],
                $contract->getInfoPrelevement()['bic'],
            ];
        }

        $sheet->fromArray($data,' - ','A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $this->file($filename);
    }

    private function removeDir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
