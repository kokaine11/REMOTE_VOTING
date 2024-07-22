<?php
include 'includes/session.php';

// Parse config.ini file
$parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
$title = isset($parse['election_title']) ? $parse['election_title'] : 'Election Result'; // Default title if not found

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Result: '.$title);
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 11);

// Fetch all positions
$sqlPositions = "SELECT * FROM positions ORDER BY priority ASC";
$resultPositions = $conn->query($sqlPositions);

$pageCount = 0;

while ($rowPosition = $resultPositions->fetch_assoc()) {
    $positionId = $rowPosition['id'];
    $positionDescription = $rowPosition['description'];

    $pdf->AddPage(); // Add a new page for each position
    $pageCount++;

    $content = '';
    if ($pageCount === 1) {
        // Front page
        $content .= '<h1 align="center">'.$title.'</h1>';
        $content .= '<h1 align="center">Election Result</h1>';
        
    } else {
        // Subsequent pages
        $content .= '<h1 align="center">Election Result</h1>';
    }
    $content .= '<h2 align="center">'.$positionDescription.'</h2>';

    $content .= '
        <table border="1" cellspacing="0" cellpadding="3">
            <tr style="background-color: #f2f2f2; color: #333;">
                <td width="30%" style="text-align: center; background-color: #4CAF50; color: white;"><b>Candidate Name</b></td>
                <td width="30%" style="text-align: center; background-color: #4CAF50; color: white;"><b>Image</b></td>
                <td width="20%" style="text-align: center; background-color: #4CAF50; color: white;"><b>Votes</b></td>
                <td width="20%" style="text-align: center; background-color: #4CAF50; color: white;"><b>Percentage</b></td>
            </tr>
    ';

    // Fetch candidates for the current position
    $sqlCandidates = "SELECT * FROM candidates WHERE position_id = '$positionId' ORDER BY lastname ASC";
    $resultCandidates = $conn->query($sqlCandidates);
    $candidates = array();

    while ($candidateRow = $resultCandidates->fetch_assoc()) {
        $candidates[] = $candidateRow;
    }

    // Calculate total votes for the position
    $totalVotesPosition = 0;
    foreach ($candidates as $candidate) {
        $sqlVotes = "SELECT * FROM votes WHERE candidate_id = '".$candidate['id']."'";
        $resultVotes = $conn->query($sqlVotes);
        $votes = $resultVotes->num_rows;
        $totalVotesPosition += $votes;
    }

    // Generate rows for each candidate
    foreach ($candidates as $candidate) {
        $sqlVotes = "SELECT * FROM votes WHERE candidate_id = '".$candidate['id']."'";
        $resultVotes = $conn->query($sqlVotes);
        $votes = $resultVotes->num_rows;

        // Calculate percentage
        $percentage = ($totalVotesPosition > 0) ? round(($votes / $totalVotesPosition) * 100, 2) : 0;
        $pictureUrl = (!empty($candidate['photo'])) ? '../images/'.$candidate['photo'] : '../images/profile.jpg';

        $content .= '
            <tr>
                <td style="text-align: center;"><br><br><br><br>'.$candidate['lastname'].' '.$candidate['firstname'].'</td>
                <td style="text-align: center;"><img src="'.$pictureUrl.'" alt="'.$candidate['lastname'].'" width="120" height="100"></td>
                <td style="text-align: center;"><br><br><br><br>'.$votes.'</td>
                <td style="text-align: center;"><br><br><br><br>'.$percentage.'%</td>
            </tr>
        ';
    }

    $content .= '</table>';

    $pdf->writeHTML($content);
}

$pdf->Output('election_result.pdf', 'I');
?>
