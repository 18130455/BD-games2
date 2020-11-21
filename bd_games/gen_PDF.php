<?require_once 'connect.php'; ?>
<?ob_end_clean();ob_clean();?>
<?require_once 'tcpdf/tcpdf.php';?>
<?
    $ww = iconv('windows-1251', 'UTF-8', "Привет");
    $array = array("№ п/п", "Название", "жанр", "разработчик", "издатель", "цифровой ключ", 
    "дата приобретения", "дата окончания", "url магазина");
    ob_clean();
    error_reporting(E_ALL);
    ob_start();
    $pdf = new TCPDF('P', 'mm', 'A3', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAuthor('Лосева ПИ-319');
    $pdf->SetTitle('Ключи');
    $pdf->SetMargins(20, 30, 20);

    $pdf->SetFont('arial', '', 9, '', true);
    $pdf->AddPage();
    $pdf->SetXY(20, 50);
    $pdf->SetDrawColor(100, 100, 0);
    $pdf->SetTextColor(0, 0, 0);
    $html = '<h1>Ключи</h1><br>';
    $html .= "<table border='2' bordercolor='red' >";
    $html .= "<tr>";
    for($i = 0; $i < count($array); $i++){
        $html .= "<th>$array[$i]</th>";
    }
    $html .= "</tr>";
    $zapros = "SELECT * FROM f0472780_loseva.key_info ORDER BY id_game";
    $link = mysqli_connect($host, $user, $password) or die ("Невозможно подключиться к серверу"); 
    $result = mysqli_query($link, $zapros); 
    while ($row=mysqli_fetch_array($result)){
         $html .= "<tr align='center'>";
        for($i = 0; $i < count($row)/2; $i++){
            $text = $row[$i];
             $html .= "<td>$text</td>";
        }
		 $html .= "</tr>";
    }
    
    $html .= "";
    $html .= "";
    $html .= "</table>";
    
   
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output('Key.pdf', 'I');
?>