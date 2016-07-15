<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');
set_time_limit(0);
$records = array(); 
$workIds = array();

if (isset($_SESSION['flaggedImages']))
{
    // Define array of flagged images, and number to export
    $exportFlagged_count = count($_SESSION['flaggedImages']);
    $flaggedImages_str = '';
    
    foreach ($_SESSION['flaggedImages'] as $key=>$val) 
    {
        $flaggedImages_str .= $val . ',';
    }
    
    $flaggedImages_str = rtrim($flaggedImages_str, ', ');
}
//query for inital record information
if (isset($_GET['type']) && $_GET['type'] == 'range')
{
    // User enetered a range of image records
    // Define first and last records to export
    $start = $_GET['first'];
    $end = $_GET['last'];

    $sql = "SELECT legacy_id, related_works FROM $DB_NAME.image 
                WHERE id BETWEEN {$start} AND {$end} ";
    // Establish query fragment to be used below 
    // to update images records after export is complete
    $updateThese = "id BETWEEN {$start} AND {$end}";
    // Define filename for the XML to be output.
    // Will be used below.
    $filename = "dimli_exportXML__". $start ."-". $end ."__". date('Y.m.d');
}

elseif (isset($_GET['type']) && $_GET['type'] == 'flagged')
{
    // User exported all flagged and approved images
    $sql = "SELECT legacy_id, related_works FROM $DB_NAME.image 
                WHERE id IN({$flaggedImages_str}) ";
    // Establish query fragment to be used below 
    // to update images records after export is complete
    $updateThese = " id IN({$flaggedImages_str}) ";
    // Define filename for the XML to be output.
    // Will be used below.
    $filename = "dimli_exportXML__FlaggedApproved__". date('Y.m.d');
}

$result = db_query($mysqli, $sql);
// Create array of record numbers
while ($row = $result->fetch_assoc())
{
    if (!empty($row['related_works']))
    {
        $export[]='work_'.$row['related_works'];       
        $export[]='image_'.$row['legacy_id'];                
    }
}
//Remove duplicate work entries
$records = array_unique($export);
//Begin XML
//create a dom document
$domtree = new DOMDocument('1.0', 'UTF-8');
// create a root element of the xml tree
$vra = $domtree->createElement('vra');
//create attributes for element
$vra->setAttribute('xmlns', 'http://www.vraweb.org/vracore4.htm');
$vra->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
$vra->setAttribute('xsi:schemaLocation', 'http://www.vraweb.org/vracore4.htm http://www.loc.gov/standards/vracore/vra-strict.xsd');
// append element to the doc
$vra = $domtree->appendChild($vra);
// get fields for export and create array
$fields = explode(',', $_GET['fields']);
$elementSets = array();
//create  elementSets elements
foreach ($fields as $field)
{   
    $elementSets[] = $field.'Set'; 
}

$display = 'display';

// set counting variables
$w = 1;
$i = 1;

// create initial elements for each record
foreach ($records as $record)
{           
    if (preg_match('/work/', $record))
    {
        
        $recordId = str_replace('work_', '', $record);
        $refNum = $recordId;    
        $type = 'work';
        $id ='w_'.$w;
        $w++;

        $elementIsWork = $domtree->createElement('work');
        $elementIsWork = $vra->appendChild($elementIsWork);    
    
        $elementAttributes=array('dataDate'=>date('Y-m-d'), 'xml:lang'=>'English','refid'=>$recordId, 'id'=>$id); 

        foreach ($elementAttributes as $key=>$value)                
        {   
            $elementIsWork->setAttribute($key, $value);
        }    
    }
    elseif (preg_match('/image/', $record))
    {   

        $recordId = str_replace('image_', '', $record);
        
        $sql = "SELECT id
                FROM $DB_NAME.image
                WHERE legacy_id = '{$recordId}'";

            $idResult = $mysqli->query($sql);   

            while ($row = $idResult->fetch_assoc())        
            {    
                $thisId=$row['id']; 
                $refNum = create_six_digits($thisId);
            }       


            
        $type ='image';
        $id='i_'.$i;
        $i++; 

        $elementIsImage = $domtree->createElement('image');
        $elementIsImage = $elementIsWork->appendChild($elementIsImage);
        
        $elementAttributes=array('dataDate'=>date('Y-m-d'), 'xml:lang'=>'English','refid'=>$recordId, 'id'=>$id); 
        
        foreach ($elementAttributes as $key=>$value)                
        {   
            $elementIsImage->setAttribute($key, $value);
        } 

        
    }       
        
    foreach ($elementSets as $elementSet)
    {
        $p=0; 
        $displayTexts=array();
        $displayText =''; 

        if ($elementSet == 'agentSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.agent 
                    WHERE related_".$type."s = '{$refNum}'";

                $agentResult = $mysqli->query($sql);   

                while ($row = $agentResult->fetch_assoc())
                {
                    $attribution = $row['agent_attribution'];
                    $name = $row['agent_text'];
                    $refid = $row['agent_getty_id'];

                $sql = "SELECT birth_date, death_date FROM getty_ulan WHERE getty_id ='{$refid}'";
                      
                      $resultGetty = $mysqli->query($sql);   

                      
                      while ($row = $resultGetty->fetch_assoc())  
                      {  
                            $early = $row['birth_date'];
                            $late = $row['death_date'];

                            if (!empty($attribution) && !empty($name) && !empty($late))
                            {    
                                $displayText = $attribution.' '.$name.' ('.$early.'-'.$late.')';
                            }
                            else if (!empty($attribution) && !empty($name) && !empty($early))
                            {    
                                $displayText = $attribution.' '.$name.' ('.$early.')';
                            }
                            else if (!empty($name) && !empty($late))
                            {
                                $displayText = $name.' ('.$early.'-'.$late.')';
                            }
                            else if (!empty($name) && !empty($early))
                            {    
                                $displayText = $name.' ('.$early.')';
                            }
                            else if (!empty($attribution) && !empty($name))
                            {    
                                $displayText = $attribution.' '.$name;
                            }
                            else
                            {
                                $displayText = $name;
                            }
                        }    

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql= " SELECT * 
                FROM $DB_NAME.agent 
                WHERE related_".$type."s = '{$refNum}'";

                $agentAgain = $mysqli->query($sql);   

                while ($row = $agentAgain->fetch_assoc())
                {
                    $attribution = $row['agent_attribution'];
                    $name = $row['agent_text'];
                    $role = $row['agent_role'];
                    $refid = $row['agent_getty_id'];
                    $nameType =strtolower($row['agent_type']);
                    
                    
                 $sql = "SELECT pref_nationality_type, birth_date, death_date FROM getty_ulan WHERE getty_id = '{$refid}' ";
                      
                      $gettyAgain = $mysqli->query($sql);   

                    while ($row = $gettyAgain->fetch_assoc())  
                     {  
                            $content ='';
                            $culture = $row['pref_nationality_type'];
                            $early = $row['birth_date'];
                            $late = $row['death_date'];
                            $datesType ='life';
                            
                            if (!empty($refid))
                            {
                                $vocab = 'AAT';
                            }
                            else
                            {
                                $vocab ='';
                            }    
                            
                            if ($p == 0) 
                            {
                                $pref = 'true';   
                            }
                            else
                            {    
                                $pref = 'false';
                            }
                             
                            if (!empty($name))
                            {
                                if (preg_match('/work/', $record) && $p == 0)
                                {    
                                    $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                                    $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                    $p++; 
                                }
                                
                                if (preg_match('/image/', $record) && $p == 0)
                                {
                                    $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                                    $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                    $p++;    
                                }

                                $addField = $addElementSet->appendChild($domtree->createElement('agent', $content));
                                $addField->setAttribute('pref', $pref);
                                
                                $nameAttributes=array('type'=>$nameType, 'refid'=>$refid, 'vocab'=>$vocab); 
                                
                                $thirdChildren=array('earliestDate'=>$early,'latestDate'=>$late);
                                
                                $secondChildren=array('attribution'=>$attribution,'culture'=>$culture,'dates'=>'','name'=>$name,'role'=>$role);
                                
                                foreach ($secondChildren as $key=>$value)
                                {
                                    if (!empty($value))
                                    {                            
                                        $addChildren = $addField->appendChild($domtree->createElement($key, $value)); 
                                    }

                                    if($key == 'date')
                                    {
                                        $key->setAttribute('type', $datesType);                 
                                        
                                        foreach($thirdChildren as $k=>$v)
                                        {
                                            if (!empty($v))
                                            {
                                            $date = $key->appendChild($domtree->createElement($k, $v));
                                            }   
                                        }
                                    }

                                    if ($key == 'name')
                                    {
                                        foreach($nameAttributes as $k=>$v)
                                        {
                                            if (!empty($v))
                                            {
                                                $addChildren->setAttribute($k, $v);
                                            }
                                        }
                                    }     
                                }      
                            }          
                        }
                }
        }

        elseif ($elementSet == 'culturalContextSet')
        {    
            $sql="SELECT *
                    FROM $DB_NAME.culture 
                    WHERE related_".$type."s = '{$refNum}'";

                $cultureResult = $mysqli->query($sql);   
                 
                while ($row = $cultureResult->fetch_assoc())
                {  
                    $displayText = $row['culture_text'];

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);    

                $sql="SELECT *
                    FROM $DB_NAME.culture 
                    WHERE related_".$type."s = '{$refNum}'";

                $cultureAgain = $mysqli->query($sql);   
                 
                while ($row = $cultureAgain->fetch_assoc())
                {      

                    $content=$row['culture_text'];
                    $refid = $row['culture_getty_id'];
                    $displayNum = $row['display'];
                                       
                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='';
                    }    
                
                    if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }  
                   
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                       
                        $addField = $addElementSet->appendChild($domtree->createElement('culturalContext', $content));
                        
                        $fieldAttributes=array('pref'=>$pref,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($fieldAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        }

        elseif ($elementSet == 'dateSet')
        {
            $sql= " SELECT * 
                    FROM $DB_NAME.date
                    WHERE related_".$type."s = '{$refNum}'";

                $dateResult = $mysqli->query($sql);   

                while ($row = $dateResult->fetch_assoc())
                {
                    $range = $row['date_range'];
                    $earlyDate = $row['date_text'];
                    $lateDate = $row['enddate_text'];

                    if (!empty($earlyDate))
                    {
                        $early = $row['date_text'].' '.$row['date_era'];
                        
                        if (!empty($lateDate))
                        {
                        $late = $row['enddate_text'].' '.$row['enddate_era'];
                        }

                        if ($range == 1)
                        {
                            $displayText = $early.'-'.$late;
                        }
                        else
                        {
                            $displayText = $early;     
                        }
                    }

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);

                $sql= " SELECT * 
                    FROM $DB_NAME.date
                    WHERE related_".$type."s = '{$refNum}'";

                $dateAgain = $mysqli->query($sql);   

                while ($row = $dateAgain->fetch_assoc())
                {
                    $content ='';
                    $range = $row['date_range'];
                    $circaVal = $row['date_circa'];
                    $early = $row['date_text'];
                    $late = $row['enddate_text'];

                    $datesType = strtolower($row['date_type']);
                
                    if ($circaVal == '1')
                    {
                        $circa = 'true';   
                    }
                    else
                    {
                        $circa = 'false';
                    }

                    if ($p == 0) 
                    {
                        $pref = 'true';   
                    }
                    else
                    {    
                        $pref = 'false';
                    }
                   
                    if (!empty($earlyDate))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('date', $content));
                        
                        if (!empty($datesType))
                        {    
                            $addField->setAttribute('type', $datesType);
                        }

                        $addField->setAttribute('pref', $pref);
                        
                        $secondChildren=array('earliestDate'=>$early,'latestDate'=>$late);
                        
                        foreach ($secondChildren as $key=>$value)
                        {
                            if (!empty($value))
                            {                            
                                $addChildren = $addField->appendChild($domtree->createElement($key, $value)); 
                                $addChildren->setAttribute('circa', $circa);
                            } 
                        }      
                    }          
                }
        }

        elseif ($elementSet == 'descriptionSet')
        {
            if (preg_match('/work/', $record))
            {    
                $sql= " SELECT description
                        FROM $DB_NAME.work
                        WHERE id = '{$recordId}'";
            }
            
            else
            {
                $sql= " SELECT description
                        FROM $DB_NAME.image
                        WHERE legacy_id = '{$recordId}'";
            }            

                $descriptionResult = $mysqli->query($sql);

                while ($row = $descriptionResult->fetch_assoc()){

                    $displayText =$row['description'];
                    
                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);

            if (preg_match('/work/', $record))
            {    
                $sql= " SELECT description
                        FROM $DB_NAME.work
                        WHERE id = '{$refNum}'";
            }
            
            else
            {
                $sql= " SELECT description
                        FROM $DB_NAME.image
                        WHERE legacy_id = '{$refNum}'";
            }            

                $descriptionAgain = $mysqli->query($sql);        

                while ($row = $descriptionAgain->fetch_assoc())
                {
                    $content =$row['description'];

                    if ($p == 0) 
                    {
                        $pref = 'true';  
                    }
                    else
                    {    
                        $pref = 'false';
                    }
                
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                       
                        $addField = $addElementSet->appendChild($domtree->createElement('description', $content));
                        $addField->setAttribute('pref', $pref);
                    }          
                }
        }

        elseif ($elementSet == 'inscriptionSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.inscription
                    WHERE related_".$type."s = '{$refNum}'";

                $inscriptionResult = $mysqli->query($sql);   

                while ($row = $inscriptionResult->fetch_assoc())
                {
                    $position = $row['inscription_location'];
                    $text = $row['inscription_text'];
                    
                    if (!empty($position))
                    {
                        $displayText = $position.', '.$text;
                    }
                    else
                    {
                        $displayText = $text;
                    }

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql = " SELECT * 
                FROM $DB_NAME.inscription
                WHERE related_".$type."s = '{$refNum}'";

                $inscriptionAgain = $mysqli->query($sql);   

                while ($row = $inscriptionAgain->fetch_assoc())
                { 
                    $content ='';
                    $author = $row['inscription_author'];
                    $position = $row['inscription_location'];
                    $text = $row['inscription_text'];
                    $inscriptionType =strtolower($row['inscription_type']);

                    if ($p == 0) 
                    {
                        $pref = 'true';
                           
                    }
                    else
                    {    
                        $pref = 'false';
                    }

                    $secondChildren=array('author'=>$author,'position'=>$position, 'text'=>$text);
                
                    if (!empty($text))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('inscription', $content));
                        $addField->setAttribute('pref', $pref);
                      
                        foreach ($secondChildren as $key=>$value)
                        {
                            if (!empty($value))
                            {                            
                                $addChildren = $addField->appendChild($domtree->createElement($key, $value)); 
                            }    

                            if ($key == 'text' && !empty($inscriptionType))
                            {
                                $addChildren->setAttribute('type', $inscriptionType); 
                            }
                        } 
                                       
                    }          
                }
        }

        elseif ($elementSet == 'locationSet')
        {
            $sql= " SELECT * 
                    FROM $DB_NAME.location
                    WHERE related_".$type."s = '{$refNum}'";

                $locationResult = $mysqli->query($sql);   

                while ($row = $locationResult->fetch_assoc())
                {
                    $locationName = $row['location_text'];
                    $locationType = strtolower($row['location_type']);
                    
                    if (!empty($locationType))
                    {
                        $displayText = $locationName.' ('.$locationType.')';
                    }
                    else
                    {
                        $displayText = $locationName;
                    }

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);

            $sql= " SELECT * 
                FROM $DB_NAME.location
                WHERE related_".$type."s = '{$refNum}'";

                $locationAgain = $mysqli->query($sql);   

                while ($row = $locationAgain->fetch_assoc())
                { 
                    $content = '';
                    $locationName = $row['location_text'];
                    $locationType = strtolower($row['location_type']);
                    $refid = $row['location_getty_id'];
                    $nameType = strtolower($row['location_name_type']);

                 if (!empty($refid) && !preg_match('/work/', $refid))
                    {
                        $vocab = 'TGN';
                    }
                    else
                    {
                        $vocab ='';
                        $refid ='';
                    }    

                    if ($p == 0) 
                    {
                        $pref = 'true';
                           
                    }
                    else
                    {    
                        $pref = 'false';
                    }
                
                    if (!empty($locationName))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                
                        $addField = $addElementSet->appendChild($domtree->createElement('location', $content));
                        $addField->setAttribute('pref', $pref);
                        
                        if (!empty($nameType))
                        {
                            $addField->setAttribute('type', $nameType);
                        }

                        if (!empty($locationName))
                        {                            
                            $addChildren = $addField->appendChild($domtree->createElement('name', $locationName)); 
                        }

                        $childAttributes=array('type'=>$locationType,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($childAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }  
                        }                        
                    }          
                }
        }

        elseif ($elementSet == 'materialSet')
        {    
            $sql= "SELECT *
                    FROM $DB_NAME.material 
                    WHERE related_".$type."s = '{$refNum}'";

                $materialResult = $mysqli->query($sql);   
                 
                while ($row = $materialResult->fetch_assoc())
                {  
                    $materialText=$row['material_text'];
                    $materialType=strtolower($row['material_type']);

                    if (!empty($materialType) && $materialType == 'Support')
                    {
                        $displayText ='on '.$materialText;    
                    }
                    else
                    {
                        $displayText = $materialText;    
                    }

                    if (!empty($displayText))    
                    {    
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode(' ', $displayTexts);    

                $sql="SELECT * 
                    FROM $DB_NAME.material 
                    WHERE related_".$type."s = '{$refNum}'";

                $materialAgain = $mysqli->query($sql);   
                 
                while ($row = $materialAgain->fetch_assoc())
                {      

                    $content=$row['material_text'];
                    $materialType=strtolower($row['material_type']);
                    $refid = $row['material_getty_id'];
                    $displayNum = $row['display'];                                       

                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='';
                    }

                    if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }      
                
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                        $addField = $addElementSet->appendChild($domtree->createElement('material', $content));
                        
                        $fieldAttributes=array('type'=>$materialType, 'pref'=>$pref, 'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($fieldAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        } 
      
        elseif ($elementSet == 'measurementsSet')
        {    
            $basicUnitMeasurements = array('circumference','depth','diameter','distance between','height','length','width');
          
            $sql="SELECT *
                FROM $DB_NAME.measurements 
                WHERE related_".$type."s = '{$refNum}'";

                $measurementsResult = $mysqli->query($sql);  
                
                while ($row = $measurementsResult->fetch_assoc()) 
                {

                    $measurementsType =strtolower($row['measurements_type']);
                    $displayText = $row['measurements_text'];
                    
                    if (in_array($measurementsType , $basicUnitMeasurements)) 
                    {
                        $displayText .= ' ' . $row['measurements_unit'].' ('.$row['measurements_type'].')';
                    } 
                    elseif ($measurementsType  == 'area') 
                    {
                        $displayText .= ' ' . $row['area_unit'].' ('.$row['measurements_type'].')';
                    } 
                    elseif ($measurementsType  == 'bit depth') 
                    {
                        $displayText .= ' bit'.' ('.$row['measurements_type'].')';
                    } 
                    
                    if ($measurementsType  == 'file size') 
                    {
                        $displayText .= ' ' . $row['filesize_unit'].' ('.$row['measurements_type'].')';
                    } 
                    elseif ($measurementsType  == 'scale') 
                    {
                        $displayText .= ' equals ' . $row['measurements_text_2'] . ' ' . $row['measurements_unit_2'].' ('.$row['measurements_type'].')';
                    } 
                    elseif ($measurementsType  == 'weight') 
                    {
                        $displayText .= ' ' . $row['weight_unit'].' ('.$row['measurements_type'].')';
                    } 
                    elseif ($measurementsType  == 'other') 
                    {
                        $displayText .= ' - ' . $row['measurements_description'].' ('.$row['measurements_type'].')';
                    }   
                    elseif ($measurementsType  == 'duration' || $measurementsType  == 'Running time') 
                    {
                            // Measurement is a duration, so uses the duration fields
                            $displayText = ($row['duration_days'] != '0') ? $row['duration_days'] . ' days' : '';
                            $displayText .= ($row['duration_days'] != '0' && $row['duration_hours'] != '0') ? ', ' : '';
                            $displayText .= ($row['duration_hours'] != '0') ? $row['duration_hours'] . ' hours' : '';
                            $displayText .= ($row['duration_hours'] != '0' && $row['duration_minutes']) ? ', ' : '';
                            $displayText .= ($row['duration_minutes'] != '0') ? $row['duration_minutes'] . ' minutes' : '';
                            $displayText .= ($row['duration_minutes'] != '0' && $row['duration_seconds'] != '0') ? ', ' : '';
                            $displayText .= ($row['duration_seconds'] != '0') ? $row['duration_seconds'] . ' seconds' : '';
                            $displayText .= ' ('.$row['measurements_type'].')';   
                    } 
                    elseif ($row['measurements_type'] == 'resolution') 
                    {
                        // Measurement is a screen resolution, so uses the resolution field
                        $displayText = $row['resolution_width'] . ' x ' . $row['resolution_height'].' ('.$row['measurements_type'].')';
                    }

                    if ($row['measurements_unit'] == 'ft' && $row['inches_value'] !='0') 
                    {
                        $displayText = $row['measurements_text'].' '.$row['measurements_unit'].', '.$row['inches_value'].' in'.' ('.$row['measurements_type'].')';
                    } 

                    if (!empty($displayText))    
                    {    
                        $displayTexts[] = $displayText;
                    }       
                }    

            $displayThis = implode('; ', $displayTexts);    

            $sql = "SELECT * 
                FROM $DB_NAME.measurements 
                WHERE related_".$type."s = '{$refNum}'";

            $measurementsAgain = $mysqli->query($sql);   
             
            while ($row = $measurementsAgain->fetch_assoc())
            {      

                $measurementsText = $row['measurements_text'];
                 $measurementsType =strtolower($row['measurements_type']);

                if ($measurementsType == 'distance between')
                {
                    $measurementsType ='distanceBetween';
                }     
                
                if ($measurementsType == 'running time'){
                    $measurementsType = 'runningTime';
                }

                if (in_array($measurementsType, $basicUnitMeasurements)) 
                {
                    $unit = $row['measurements_unit'];
                }  
                elseif ($measurementsType == 'area') 
                {
                    $unit = $row['area_unit'];
                } 
                elseif ($measurementsType == 'bit depth') 
                {
                    $unit = 'bit';
                } 
                elseif ($measurementsType == 'file size') 
                {
                    $unit=$row['filesize_unit'];
                    $measurementsType == 'fileSize';

                } 
                elseif ($measurementsType == 'scale') 
                {
                    $measurementsText .= ' equals ' . $row['measurements_text_2'];
                    $unit = $row['measurements_unit_2'];
                } 
                elseif ($measurementsType == 'weight') 
                {
                    $unit = $row['weight_unit'];
                } 
                elseif ($measurementsType == 'other') 
                {
                    $measurementsText = $row['measurements_description'];
                    $unit ='';
                }    
                elseif ($measurementsType == 'duration' || $measurementsType == 'Running time') 
                {
                    // Measurement is a duration, so uses the duration fields
                    $measurementsText= ($row['duration_days'] != '0') ? $row['duration_days'] . ' days' : '';
                    $measurementsText .= ($row['duration_days'] != '0' && $row['duration_hours'] != '0') ? ', ' : '';
                    $measurementsText .= ($row['duration_hours'] != '0') ? $row['duration_hours'] . ' hours' : '';
                    $measurementsText .= ($row['duration_hours'] != '0' && $row['duration_minutes']) ? ', ' : '';
                    $measurementsText .= ($row['duration_minutes'] != '0') ? $row['duration_minutes'] . ' minutes' : '';
                    $measurementsText .= ($row['duration_minutes'] != '0' && $row['duration_seconds'] != '0') ? ', ' : '';
                    $measurementsText .= ($row['duration_seconds'] != '0') ? $row['duration_seconds'] . ' seconds' : '';
                    $unit =''; 
                } 
                elseif ($measurementsType == 'resolution') 
                {
                    // Measurement is a screen resolution, so uses the resolution field
                    $measurementsText = $row['resolution_width'] . ' x ' . $row['resolution_height'];
                    $unit ='';
                }

                if (!empty($measurementsText) && $unit == 'ft' && $row['inches_value'] !='0') 
                {
                    $measurementsText = $row['measurements_text'].' '.$row['measurements_unit'].', '.$row['inches_value'].' in';
                }

                if ($p == 0) 
                {
                    $pref = 'true';
                       
                }
                else
                {    
                    $pref = 'false';
                }
                
                if (!empty($measurementsText))
                {
                    if (preg_match('/work/', $record) && $p == 0)
                    {    
                        $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                        $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                        $p++; 
                    }
                    
                    if (preg_match('/image/', $record) && $p == 0)
                    {
                        $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                        $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                        $p++;    
                    }

                    $addField = $addElementSet->appendChild($domtree->createElement('measurements', $measurementsText));
                    
                    $fieldAttributes=array('type'=>$measurementsType,'unit'=>$unit, 'pref'=>$pref);

                    foreach ($fieldAttributes as $key=>$value)
                    {
                        if (!empty($value))
                        {
                            $addField->setAttribute($key, $value);
                        }
                    }
                }   
            }                       
        }
        
        elseif ($elementSet == 'relationSet' && $type == 'work')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.relation 
                    WHERE related_".$type."s = '{$refNum}'";

                $relationResult = $mysqli->query($sql);   

                while ($row = $relationResult->fetch_assoc())
                {
                    $relatedTo = $row['relation_id'];
                    $relationType = $row['relation_type'];
                    
                    if (!empty($relatedTo))
                     {   
                        $sql = "SELECT title_text 
                            FROM $DB_NAME.title 
                            WHERE related_works = '{$relatedTo}'";
                          
                            $resultRelationTitle = $mysqli->query($sql);   

                            while ($row = $resultRelationTitle->fetch_assoc())
                            {
                                $relatedTitle = $row['title_text'];

                                if (!empty($relationType) && !empty($relatedTitle))
                                {    
                                    $displayText = $relationType.' '.$relatedTitle;
                                }
                            } 
                     }      

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);

                $sql= " SELECT *
                        FROM $DB_NAME.relation 
                        WHERE related_".$type."s = '{$refNum}'";

                    $relationAgain = $mysqli->query($sql);   

                    while ($row = $relationAgain->fetch_assoc())
                    {
                        $relatedTo = $row['relation_id'];
                        $relationType = $row['relation_type'];
                        //$relId = 'w_'.$row['relation_id'];
                        
                        $sql = "SELECT title_text 
                            FROM $DB_NAME.title 
                            WHERE related_works = '{$relatedTo}'";
                          
                            $relationTitleAgain = $mysqli->query($sql);   

                            while ($row = $relationTitleAgain->fetch_assoc())
                            {
                                $relatedTitle = $row['title_text'];

                                if ($p == 0) 
                                {
                                    $pref = 'true';   
                                }
                                else
                                {    
                                    $pref = 'false';
                                }
                                 
                                if (!empty($relationType))
                                {
                                    if (preg_match('/work/', $record) && $p == 0)
                                    {    
                                        $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                                        $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                        $p++; 
                                    }
                                    
                                    if (preg_match('/image/', $record) && $p == 0)
                                    {
                                        $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                                        $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                        $p++;    
                                    }

                                    $addField = $addElementSet->appendChild($domtree->createElement('relation', $relatedTitle));
                                    $addField->setAttribute('type', $relationType);
                                    $addField->setAttribute('relids', $relatedTo);         
                                }          
                            }
                    }
               
        }

        elseif ($elementSet == 'rightsSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.rights
                    WHERE related_".$type."s = '{$refNum}'";

                $rightsResult = $mysqli->query($sql);   

                while ($row = $rightsResult->fetch_assoc())
                {
                    $rightsText = $row['rights_text'];
                    
                    if (!empty($rightsText))
                    {
                        $displayText = $rightsText;
                    }    

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql = " SELECT * 
                FROM $DB_NAME.rights
                WHERE related_".$type."s = '{$refNum}'";

                $rightsAgain = $mysqli->query($sql);   

                while ($row = $rightsAgain->fetch_assoc())
                { 
                    $content ='';
                    $rightsText = $row['rights_text'];
                    $rightsHolder = $row['rights_holder'];
                    
                    if ($p == 0) 
                    {
                        $pref = 'true';     
                    }
                    else
                    {    
                        $pref = 'false';
                    }

                    $secondChildren=array('rightsHolder'=>$rightsHolder,'text'=>$rightsText);
                
                    if (!empty($rightsText))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('rights', $content));
                        $addField->setAttribute('pref', $pref);
                      
                        foreach ($secondChildren as $key=>$value)
                        {
                            if (!empty($value))
                            {                            
                                $addChildren = $addField->appendChild($domtree->createElement($key, $value)); 
                            }          
                        }          
                    }
                }    
        }

        elseif ($elementSet == 'sourceSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.source
                    WHERE related_".$type."s = '{$refNum}'";

                $sourceResult = $mysqli->query($sql);   

                while ($row = $sourceResult->fetch_assoc())
                {   
                    
                    $sourceNameText = $row['source_name_text'];
                
                    if (!empty($sourceNameText))
                    {
                        $displayText = $sourceNameText;
                    }    

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql = " SELECT * 
                FROM $DB_NAME.source
                WHERE related_".$type."s = '{$refNum}'";

                $sourceAgain = $mysqli->query($sql);   

                while ($row = $sourceAgain->fetch_assoc())
                { 
                    $sourceNameType = strtolower($row['source_name_type']);
                    $sourceNameText = $row['source_name_text'];
                    $sourceType = ($row['source_type']);
                    $sourceText = $row['source_text'];

                    if ($sourceType ='Citation')
                    {
                        $sourceType ='citation';
                    }
                    if ($sourceType ='Open URL')
                    {
                        $sourceType ='openURL';
                    }
                    if ($sourceType ='Other')
                    {
                        $sourceType ='other';
                    }
                    if ($sourceType ='Vendor')
                    {
                        $sourceType ='vendor';
                    }

                    $secondChildren=array('name'=>$sourceNameText,'refid'=>$sourceText);
                
                    if (!empty($sourceText))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('source', $content));
                      
                        foreach ($secondChildren as $key=>$value)
                        {
                            if (!empty($value))
                            {                            
                                $addChildren = $addField->appendChild($domtree->createElement($key, $value)); 
                            }

                            if ($key == 'refid')
                            {
                                $addChildren->setAttribute('type', $sourceType);
                            }

                            if ($key == 'name')
                            {
                                $addChildren->setAttribute('type', $sourceNameType);
                            }
                        }          
                    }
                }    
        }

        elseif ($elementSet == 'stateEditionSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.edition
                    WHERE related_".$type."s = '{$refNum}'";

                $editionResult = $mysqli->query($sql);   

                while ($row = $editionResult->fetch_assoc())
                {   
                    
                    $editionText = $row['edition_text'];
                
                    if (!empty($editionText))
                    {
                        $displayText = $editionText;
                    }    

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql = " SELECT * 
                FROM $DB_NAME.edition
                WHERE related_".$type."s = '{$refNum}'";

                $editionAgain = $mysqli->query($sql);   

                while ($row = $editionAgain->fetch_assoc())
                { 
   
                    $editionType = $row['edition_type'];
                    $editionText = $row['edition_text'];
                
                    if (!empty($editionText))
                    {
                        if ($p == 0) 
                        {
                            $pref = 'true';     
                        }
                        else
                        {    
                            $pref = 'false';
                        }

                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('stateEdition', $content));
                        $addField->setAttribute('pref', $pref);

                        if (!empty($editionType))
                        {
                            $addField->setAttribute('type', $editionType);        
                        }
                        
                        $addChildren = $addField->appendChild($domtree->createElement('description', $editionText)); 
                                  
                    }
                }
        }

        elseif ($elementSet == 'stylePeriodSet')
        {    
            $sql="SELECT *
                    FROM $DB_NAME.style_period 
                    WHERE related_".$type."s = '{$refNum}'";

                $style_periodResult = $mysqli->query($sql);   
                 
                while ($row = $style_periodResult->fetch_assoc())
                {  
                    $displayText = $row['style_period_text'];

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);    

                $sql="SELECT *
                    FROM $DB_NAME.style_period 
                    WHERE related_".$type."s = '{$refNum}'";

                $style_periodAgain = $mysqli->query($sql);   
                 
                while ($row = $style_periodAgain->fetch_assoc())
                {      

                    $content=$row['style_period_text'];
                    $refid = $row['style_period_getty_id'];
                    $displayNum = $row['display'];
                                       
                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='';
                    }    
                
                    if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }  
                   
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                        $addField = $addElementSet->appendChild($domtree->createElement('stylePeriod', $content));
                        
                        $fieldAttributes=array('pref'=>$pref,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($fieldAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        }

        elseif ($elementSet == 'subjectSet')
        {    
            $sql="SELECT *
                    FROM $DB_NAME.subject 
                    WHERE related_".$type."s = '{$refNum}'";

                $subjectResult = $mysqli->query($sql);   
                 
                while ($row = $subjectResult->fetch_assoc())
                {  
                    $displayText = $row['subject_text'];

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);    

                $sql="SELECT *
                    FROM $DB_NAME.subject 
                    WHERE related_".$type."s = '{$refNum}'";

                $subjectAgain = $mysqli->query($sql);   
                 
                while ($row = $subjectAgain->fetch_assoc())
                {      

                    $content='';
                    $subjectTerm =$row['subject_text'];
                    $refid = $row['subject_getty_id'];
                    $termType = ($row['subject_type']);
                    $displayNum = $row['display'];

                    if ($termType =='Place: built work')
                    { 
                        $termType = 'builtworkPlace';
                    }    
                    if ($termType =='Topic: concept')
                    { 
                        $termType = 'conceptTopic';
                    }
                    if ($termType =='Name: corporate')
                    { 
                        $termType = 'corporateName';
                    }
                    if ($termType =='Topic: descriptive')
                    { 
                        $termType = 'descriptiveTopic';
                    }
                    if ($termType =='Name: family')
                    { 
                       $termType = 'familyName';
                    }
                    if ($termType =='Place: geographic')
                    { 
                        $termType = 'geographicPlace';
                    }    
                    if ($termType =='Topic: iconographic')
                    { 
                        $termType = 'iconographicTopic';
                    }
                    if ($termType =='Name: other')
                    { 
                        $termType = 'otherName';
                    }
                    if ($termType =='Place: other')
                    { 
                        $termType = 'otherPlace';
                    }
                    if ($termType =='Topic: other')
                    { 
                        $termType = 'otherTopic';
                    }
                    if ($termType =='Name: personal')
                    { 
                        $termType = 'personalName';
                    }
                    if ($termType =='Name: scientific')
                    { 
                        $termType = 'scientificName';
                    }

                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='ICA';
                    }    
                
                    if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }  
                   
                    if (!empty($subjectTerm))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                       
                        $addField = $addElementSet->appendChild($domtree->createElement('subject', $content));
                        $addField->setAttribute('pref', $pref);

                        $addSecondChild = $addField->appendChild($domtree->createElement('term', $subjectTerm));

                        $secondChildAttributes=array('type'=>$termType,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($secondChildAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addSecondChild->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        }

        elseif ($elementSet == 'techniqueSet')
        {    
            $sql="SELECT *
                    FROM $DB_NAME.technique 
                    WHERE related_".$type."s = '{$refNum}'";

                $techniqueResult = $mysqli->query($sql);   
                 
                while ($row = $techniqueResult->fetch_assoc())
                {  
                    $displayText = $row['technique_text'];

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);    

                $sql="SELECT *
                    FROM $DB_NAME.technique 
                    WHERE related_".$type."s = '{$refNum}'";

                $techniqueAgain = $mysqli->query($sql);   
                 
                while ($row = $techniqueAgain->fetch_assoc())
                {      

                    $content=$row['technique_text'];
                    $refid = $row['technique_getty_id'];
                    $displayNum = $row['display'];
                                       
                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='';
                    }    
                
                   if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }    
                   
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                       
                        $addField = $addElementSet->appendChild($domtree->createElement('technique', $content));
                        
                        $fieldAttributes=array('pref'=>$pref,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($fieldAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        }

        elseif ($elementSet == 'titleSet')
        {
            $sql= " SELECT *
                    FROM $DB_NAME.title
                    WHERE related_".$type."s = '{$refNum}'";

                $titleResult = $mysqli->query($sql);   

                while ($row = $titleResult->fetch_assoc())
                {   
                    
                    $titleText = $row['title_text'];
                
                    if (!empty($titleText))
                    {
                        $displayText = $titleText;
                    }    

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

            $displayThis = implode('; ', $displayTexts);

            $sql = " SELECT * 
                FROM $DB_NAME.title
                WHERE related_".$type."s = '{$refNum}'";

                $titleAgain = $mysqli->query($sql);   

                while ($row = $titleAgain->fetch_assoc())
                { 
                    $titleType = strtolower($row['title_type']);
                    $titleText = $row['title_text'];
                
                    if (!empty($titleText))
                    {
                        if ($p == 0) 
                        {
                            $pref = 'true';     
                        }
                        else
                        {    
                            $pref = 'false';
                        }

                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }
                       
                        $addField = $addElementSet->appendChild($domtree->createElement('title', $titleText));
                        $addField->setAttribute('pref', $pref);

                        if (!empty($titleType))
                        {
                            $addField->setAttribute('type', $titleType);        
                        }
                                  
                    }
                }
        }

        elseif ($elementSet == 'worktypeSet')
        {    
            $sql="SELECT *
                    FROM $DB_NAME.work_type 
                    WHERE related_".$type."s = '{$refNum}'";

                $work_typeResult = $mysqli->query($sql);   
                 
                while ($row = $work_typeResult->fetch_assoc())
                {  
                    $displayText = $row['work_type_text'];

                    if (!empty($displayText))
                    {
                        $displayTexts[] = $displayText;
                    }       
                }  

                $displayThis = implode('; ', $displayTexts);    

                $sql="SELECT *
                    FROM $DB_NAME.work_type
                    WHERE related_".$type."s = '{$refNum}'";

                $work_typeAgain = $mysqli->query($sql);   
                 
                while ($row = $work_typeAgain->fetch_assoc())
                {      

                    $content=$row['work_type_text'];
                    $refid = $row['work_type_getty_id'];
                    $displayNum = $row['display'];
                                       
                    if (!empty($refid))
                    {
                        $vocab = 'AAT';
                    }
                    else
                    {
                        $vocab ='';
                    }    
                
                    if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }    
                   
                    if (!empty($content))
                    {
                        if (preg_match('/work/', $record) && $p == 0)
                        {    
                            $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++; 
                        }
                        
                        if (preg_match('/image/', $record) && $p == 0)
                        {
                            $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                            $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                            $p++;    
                        }

                       
                        $addField = $addElementSet->appendChild($domtree->createElement('worktype', $content));
                        
                        $fieldAttributes=array('pref'=>$pref,'refid'=>$refid, 'vocab'=>$vocab);

                        foreach ($fieldAttributes as $key=>$value)
                        {
                            if (!empty($value))
                            {
                                $addField->setAttribute($key, $value);
                            }
                        }
                    }   
                }                       
        }

         elseif ($elementSet == 'specificLocationSet')
        {    

            $sql="SELECT *
                    FROM $DB_NAME.specific_location
                    WHERE related_".$type."s = '{$refNum}'";

                $specific_locationResult = $mysqli->query($sql);   
                 
                while ($row = $specific_locationResult->fetch_assoc())
                {  
                    
                    $specific_location_type=$row['specific_location_type'];
                    $specific_location_addZip=$row['specific_location_address'].', '.$row['specific_location_zip'];
                    $specific_location_LatLng=$row['specific_location_lat'].', '.$row['specific_location_long'];
                    $specific_location_note=$row['specific_location_note'];

                    if (!empty($specific_location_type))
                    {

                        if ($specific_location_type == 'Address')
                        {
                            $displayText = $specific_location_addZip;
                        }    
                        

                        else if ($specific_location_type == 'LatLng')
                        {
                            $displayText = $specific_location_LatLng;
                        }    

                        else if ($specific_location_type == 'Note')
                        {
                            $displayText = $specific_location_note;
                        }    
                    

                        if (!empty($displayText))
                        {
                            $displayTexts[] = $displayText;
                        }       
                    }
                }

                $displayThis = implode('; ', $displayTexts);        

            $sql="SELECT *
                    FROM $DB_NAME.specific_location
                    WHERE related_".$type."s = '{$refNum}'";

                $specific_locationAgain = $mysqli->query($sql);   
                 
                while ($row = $specific_locationAgain->fetch_assoc())
                {                         
                    $specific_location_type=$row['specific_location_type'];
                    $specific_location_addZip=$row['specific_location_address'].', '.$row['specific_location_zip'];
                    $specific_location_LatLng=$row['specific_location_lat'].', '.$row['specific_location_long'];
                    $specific_location_note=$row['specific_location_note'];
                    $displayNum = $row['display'];

                     if ($displayNum == '1') 
                    {
                        $pref = 'true';       
                    }
                    else
                    {    
                        $pref = 'false';
                    }    
                   

                    if (!empty($specific_location_type))
                    {
                            if (preg_match('/work/', $record) && $p == 0)
                            {    
                                $addElementSet = $elementIsWork->appendChild($domtree->createElement($elementSet));
                                $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                $p++;  
                            }  
                            
                            if (preg_match('/image/', $record) && $p == 0)
                            {
                                $addElementSet = $elementIsImage->appendChild($domtree->createElement($elementSet));
                                $addDisplay = $addElementSet->appendChild($domtree->createElement('display', $displayThis));
                                $p++;    
                            }

                        if ($specific_location_type == 'Address')
                        {
                            $addField = $addElementSet->appendChild($domtree->createElement('specific_location_address', $specific_location_addZip));

                            $addField->setAttribute('pref', $pref);
                        }   

                        else if ($specific_location_type == 'LatLng')
                        {
                            $addField = $addElementSet->appendChild($domtree->createElement('specific_location_LatLng', $specific_location_LatLng));
                            $addField->setAttribute('pref', $pref);
                        }   

                        else if ($specific_location_type == 'Note')
                        {
                            $addField = $addElementSet->appendChild($domtree->createElement('specific_location_note', $specific_location_note));
                            $addField->setAttribute('pref', $pref);

                        }    
                    }
                }                           
        }                                            
    }           
}  

header("Content-type: text/xml; charset=utf-8");
header("Content-Disposition: attachment; filename={$filename}.xml");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header("Expires: 0");
//finally, save and export the file
echo $domtree->saveXML();
ob_start();
$df = fopen("php://output", 'w');
fputs($df, $filename);
fclose($df);
return ob_get_clean();

//---------------------------------------------------------
//      Update the images' "last_exported" timestamp
//---------------------------------------------------------

$timestamp = date('Y-m-d H:i:s');
$sql = "UPDATE $DB_NAME.image
            SET last_exported = '{$timestamp}',
                flagged_for_export = '0'
            WHERE {$updateThese} ";

$result_lastExported = db_query($mysqli, $sql);

?>