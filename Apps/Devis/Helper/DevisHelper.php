<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Devis\Helper;

use Apps\Devis\Entity\DevisDevis;
use Apps\Devis\Entity\DevisDevisLine;
use Core\Entity\Entity\Argument;
 
class DevisHelper
{
    /**
     * Crée un nouveau projet
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $number, $informationSociete, $informationClient, $informaitonComplementaire,
                                $dateCreated, $datePaiment, $typePaiment, $lines, $projetId, $devisId)
    {
        $devis = new DevisDevis($core);
        
        if($devisId != "")
        {
            $devis->GetById($devisId);
        }
        $devis->ProjetId->Value = $projetId;
        $devis->Number->Value = $number;
        $devis->InformationSociete->Value = $informationSociete;
        $devis->InformationClient->Value = $informationClient;
        $devis->InformationComplementaire->Value = $informaitonComplementaire;
        $devis->IsModele->Value = 1;
        $devis->DateCreated->Value = $dateCreated;
        $devis->DatePaiment->Value = $datePaiment;
        $devis->TypePaiment->Value = $typePaiment;
        $devis->Save();

        if($devisId == "")
        {
            $devisId = $core->Db->GetInsertedId();
            $devis = new DevisDevis($core);
            $devis->GetById($devisId);
        }
        
        //Sauvegarde les lignes du devis
        DevisHelper::SaveLine($core, $devisId, $lines);
        
        return true;
    }
    
    /**
     * Sauvegarde les lignes du devis
     */
    public static function SaveLine($core, $devisId, $lines)
    {
        DevisHelper::DeleteLine($core, $devisId);
        
        $lines = explode("||", $lines);
        
        foreach($lines as $line)
        {
            $line = explode(":", $line);
            
            $newline = new DevisDevisLine($core);
            $newline->DevisId->Value = $devisId;
            $newline->Prestation->Value = $line[0];
            $newline->Quantity->Value = $line[1];
            $newline->Price->Value = $line[2];
            $newline->Total->Value = $line[3];
            
            $newline->Save();
        }
    }
    
    /*
     * Supprime les lignes d'un devis
     */
    public static function DeleteLine($core, $devisId)
    {
        $line = new DevisDevisLine($core);
        $line->AddArgument(new Argument("Apps\Devis\Entity\DevisDevisLine", "DevisId", EQUAL, $devisId));
        
        $lines = $line->GetByArg();
        
        foreach($lines as $line)
        {
           $line->Delete(); 
        }
    }
    
    /*
     * Sauvegarde le devis au format PDF
     */
    public static function SaveAsPdf($core, $devisId, $content)
    {
        require('../Library/html2pdf/html2pdf.class.php');
        
        // init HTML2PDF
        $html2pdf = new \HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));

        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');

      //  $content ="<html><body><h3>sdds</h3></body></html>";
      $conten ='<table>
    <tbody><tr>
        <th colspan="3">
            <h2>Devis Numero : Numbe</h2> 
        </th>
    </tr>
    
    <tr>
        <td>
            <h3>Société</h3>
            
<textarea id="InformationSociete" name="InformationSociete">ca tourne</textarea>

        </td>
        <td></td>
        <td>   <h3>Coordonées client</h3>
      
<textarea id="InformationClient" name="InformationClient">pok</textarea>

    </td>
    </tr>
    <tr>
        <td>Date du devis : 
<input type="text" id="DateCreated" name="DateCreated" class="dateBox" onblur="DateBox.Verify(this,
quot;([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4}):
quot;,:
quot;Date invalide elle doit être au format jj/mm/aaaa:
quot;)" onmouseover:"DateBox.Init(this)" value="26/05/2016" autocapitalize="off" autocorrect="off" autocomplete="off">
<span class="fa fa-calendar " onclick="DateBox.Focus(this)" title="DateBox.EnterForChoseDate" alt=""></span></td>
        <td>Date paiement: 
<input type="text" id="DatePaiment" name="DatePaiment" class="dateBox" onblur="DateBox.Verify(this,
quot;([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4}):
quot;,:
quot;Date invalide elle doit être au format jj/mm/aaaa:
quot;)" onmouseover:"DateBox.Init(this)" autocapitalize="off" autocorrect="off" autocomplete="off">
<span class="fa fa-calendar " onclick="DateBox.Focus(this)" title="DateBox.EnterForChoseDate" alt=""></span></td>
        <td>Type de reglement: 
<input type="text" id="TypePaiment" name="TypePaiment" autocapitalize="off" autocorrect="off" autocomplete="off"></td>
    </tr>
    <tr style="border:1px solid grey">
        <td colspan="3">
            <input type="text" placeholder="Prestation" id="tbPrestation">
            <input type="text" placeholder="Nombre" id="tbNbr">
            <input type="text" placeholder="Prix" id="tbPrice">
            <i class="icon-plus-sign" value="addLigne" onclick="DevisAction.AddLine(this, 2)">
        </i></td>
    </tr>
    <tr>
        <td colspan="3">
            
            NO ELEMENT<table id="tabLine" style="border:1px solid grey">
           </table>
         </td>
    </tr>
    <tr>
        <td></td>
        <td>
            Total : <input type="text" id="tbTotal">
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><h3>Informations complémentaires</h3>
        
<textarea id="InformationComplementaire" name="InformationComplementaire">okoko</textarea>

        </td>
    </tr>  
    <tr>
        <td colspan="3" style="text-align:right">
<input type="button" id="btnSave" class="btn btn-primary" value="Enregistrer" onclick="DevisAction.SaveDevis(1, 2);"> 
<input type="button" id="btnImprime" class="btn btn-success" value="Devis.SaveAsPdf" onclick="DevisAction.SaveAsPdf(this, 2);"></td>
    </tr>
</tbody></table>';
      
        // convert
        $html2pdf->writeHTML($content, false);

        // add the automatic index
         $directory = "Data/Apps/Devis";

        // send the PDF
        $html2pdf->Output($directory.'/'.$devisId.'.pdf', 'F');
    }
}   
