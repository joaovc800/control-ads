<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');
require_once realpath(dirname(__DIR__, 1) . '/services/ChatGPT.php');

header('Content-Type: application/json');

set_time_limit(600);

$configLanguages = [
    ['id' => 2032, 'country' => 'argentina', 'code' => 'ar'],
    ['id' => 2076, 'country' => 'brazil', 'code' => 'pt-br'],
    ['id' => 2840, 'country' => 'united states', 'code' => 'en-us'],
    ['id' => 2484, 'country' => 'mexico', 'code' => 'es-mx'],
    ['id' => 2170, 'country' => 'colombia', 'code' => 'es-co'],
    ['id' => 2620, 'country' => 'portugal', 'code' => 'pt-pt'],
    ['id' => 2642, 'country' => 'romania', 'code' => 'ro'],
    ['id' => 2616, 'country' => 'poland', 'code' => 'pl'],
    ['id' => 2124, 'country' => 'canada', 'code' => 'en-ca'],
    ['id' => 2600, 'country' => 'paraguay', 'code' => 'es-py'],
    ['id' => 2858, 'country' => 'uruguay', 'code' => 'es-uy'],
    ['id' => 2250, 'country' => 'france', 'code' => 'fr'],
    ['id' => 2380, 'country' => 'italy', 'code' => 'it'],
    ['id' => 2276, 'country' => 'germany', 'code' => 'de'],
    ['id' => 2152, 'country' => 'chile', 'code' => 'es-cl'],
    ['id' => 2218, 'country' => 'ecuador', 'code' => 'es-ec'],
    ['id' => 2604, 'country' => 'peru', 'code' => 'es-pe'],
    ['id' => 2068, 'country' => 'bolivia', 'code' => 'es-bo'],
    ['id' => 2208, 'country' => 'denmark', 'code' => 'da'],
    ['id' => 2752, 'country' => 'sweden', 'code' => 'sv'],
    ['id' => 2756, 'country' => 'switzerland', 'code' => 'de-ch'],
    ['id' => 2246, 'country' => 'finland', 'code' => 'fi'],
    ['id' => 2578, 'country' => 'norway', 'code' => 'no'],
    ['id' => 2352, 'country' => 'iceland', 'code' => 'is'],
    ['id' => 2826, 'country' => 'united kingdom', 'code' => 'en-gb'],
    ['id' => 2724, 'country' => 'spain', 'code' => 'es-es'],
    ['id' => 2528, 'country' => 'netherlands', 'code' => 'nl'],
    ['id' => 2056, 'country' => 'belgium', 'code' => 'nl-be'],
    ['id' => 2566, 'country' => 'nigeria', 'code' => 'en-ng'],
    ['id' => 2231, 'country' => 'ethiopia', 'code' => 'am'],
    ['id' => 2818, 'country' => 'egypt', 'code' => 'ar-eg'],
    ['id' => 2710, 'country' => 'south africa', 'code' => 'en-za'],
    ['id' => 2012, 'country' => 'algeria', 'code' => 'ar-dz'],
    ['id' => 2356, 'country' => 'india', 'code' => 'hi-in'],
    ['id' => 2392, 'country' => 'japan', 'code' => 'ja'],
    ['id' => 2792, 'country' => 'turkey', 'code' => 'tr'],
    ['id' => 2586, 'country' => 'pakistan', 'code' => 'ur-pk'],
    ['id' => 2360, 'country' => 'indonesia', 'code' => 'id'],
    ['id' => 2320, 'country' => 'guatemala', 'code' => 'es-gt'],
    ['id' => 2372, 'country' => 'ireland', 'code' => 'en-ie'],
];


$client = new ChatGPT([
    'apiKey' => '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',
    'model' => 'gpt-4-turbo'
]);

function translateCalloutText($client, $country){

    $calloutText = [
        'Ver El Paso', 'Conocer Cómo Funciona', 'Accede al Sitio', 'Ver La Guía',
        'Descúbrelo Ya', 'Descubre Más', 'Conócelo Ya', 'Aprende Más Información',
        'Accede Y Comprueba', 'Ver La Explicación', 'Comprueba La Guía', 'Mira El Tutorial',
        'Comprueba Más', 'Aprender Más Aquí', 'Ver El Artículo', 'Ver Más en El Sitio',
        'Ver Más', 'Leer La Guía', 'Leer Más', 'Ver Aquí', 'Leer Ahora', 'Ver Todo',
        'Ver Todos Los Detalles', 'Aprende Más', 'Accede Ahora', 'Descubre Cómo', 'Ver Ahora',
        'Compruébalo Ahora', 'Comprueba Ahora', 'Accede Ya', 'Conócelo Ahora', 'Ver Los Detalles',
        'Ver Más en El Artículo', 'Conoce Los Detalles', 'Accede Al Sitio', 'Aprende Más Aquí',
        'Saber Cómo', 'Comprueba Los Detalles', 'Conoce Todo', 'Descubre Ahora',
        'Ver La Solución', 'Comprueba Ya', 'Descubre Toda la Información', 'Investiga Más Opciones',
        'Navega y Aprende', 'Explora Más Detalles', 'Sumérgete en los Detalles'
    ];

    $ramdomText = array_rand(array_flip($calloutText), 20);

    $words = implode(',', $ramdomText);

    $response = $client->sendMessage(
        "
            Eu vou lhe passar um lista de palavras quero que você traduza para o idioma principal desse pais e no final retorne um array:

            Pais: $country

            Palavras: $words
        "
    , 'Traga a resposta apenas como um array.');
    
    return json_decode($response['firstResponse'], true);
}


function formatCampaignData($value) {
    return [
        'Campaign' => $value['Campaign'] ?? '',
        'Labels' => $value['Labels'] ?? '',
        'Budget' => $value['Budget'] ?? '',
        'Budget type' => $value['Budget type'] ?? '',
        'Standard conversion goals' => $value['Standard conversion goals'] ?? '',
        'Custom conversion goal' => $value['Custom conversion goal'] ?? '',
        'Campaign Type' => $value['Campaign Type'] ?? '',
        'Networks' => $value['Networks'] ?? '',
        'Location and language targeting' => $value['Location and language targeting'] ?? '',
        'Location ID' => $value['Location ID'] ?? '',
        'Location' => $value['Location'] ?? '',
        'Languages' => $value['Languages'] ?? '',
        'Bid Strategy Type' => $value['Bid Strategy Type'] ?? '',
        'Bid Strategy Name' => $value['Bid Strategy Name'] ?? '',
        'Enhanced CPC' => $value['Enhanced CPC'] ?? '',
        'Start Date' => $value['Start Date'] ?? '',
        'End Date' => $value['End Date'] ?? '',
        'Ad Schedule' => $value['Ad Schedule'] ?? '',
        'Ad rotation' => $value['Ad rotation'] ?? '',
        'Targeting method' => $value['Targeting method'] ?? '',
        'Exclusion method' => $value['Exclusion method'] ?? '',
        'Audience targeting' => $value['Audience targeting'] ?? '',
        'Flexible Reach' => $value['Flexible Reach'] ?? '',
        'Text asset automation' => $value['Text asset automation'] ?? '',
        'Final URL expansion' => $value['Final URL expansion'] ?? '',
        'Campaign Status' => $value['Campaign Status'] ?? '',
        'Ad Group' => $value['Ad Group'] ?? '',
        'Max CPC' => $value['Max CPC'] ?? '',
        'Max CPM' => $value['Max CPM'] ?? '',
        'Target CPA' => $value['Target CPA'] ?? '',
        'Max CPV' => $value['Max CPV'] ?? '',
        'Target CPV' => $value['Target CPV'] ?? '',
        'Percent CPC' => $value['Percent CPC'] ?? '',
        'Target CPM' => $value['Target CPM'] ?? '',
        'Target ROAS' => $value['Target ROAS'] ?? '',
        'Desktop Bid Modifier' => $value['Desktop Bid Modifier'] ?? '',
        'Mobile Bid Modifier' => $value['Mobile Bid Modifier'] ?? '',
        'Tablet Bid Modifier' => $value['Tablet Bid Modifier'] ?? '',
        'TV Screen Bid Modifier' => $value['TV Screen Bid Modifier'] ?? '',
        'Display Network Custom Bid Type' => $value['Display Network Custom Bid Type'] ?? '',
        'Optimized targeting' => $value['Optimized targeting'] ?? '',
        'Ad Group Type' => $value['Ad Group Type'] ?? '',
        'Audience name' => $value['Audience name'] ?? '',
        'Age demographic' => $value['Age demographic'] ?? '',
        'Gender demographic' => $value['Gender demographic'] ?? '',
        'Income demographic' => $value['Income demographic'] ?? '',
        'Parental status demographic' => $value['Parental status demographic'] ?? '',
        'Remarketing audience segments' => $value['Remarketing audience segments'] ?? '',
        'Interest categories' => $value['Interest categories'] ?? '',
        'Life events' => $value['Life events'] ?? '',
        'Custom audience segments' => $value['Custom audience segments'] ?? '',
        'Detailed demographics' => $value['Detailed demographics'] ?? '',
        'Remarketing audience exclusions' => $value['Remarketing audience exclusions'] ?? '',
        'Tracking template' => $value['Tracking template'] ?? '',
        'Final URL suffix' => $value['Final URL suffix'] ?? '',
        'Custom parameters' => $value['Custom parameters'] ?? '',
        'Ad Group Status' => $value['Ad Group Status'] ?? '',
        'Comment' => $value['Comment'] ?? '',
        'Callout text' => $value['Callout text'] ?? '',
        'Keyword' => $value['Keyword'] ?? '',
        'Criterion Type' => $value['Criterion Type'] ?? '',
        'First page bid' => $value['First page bid'] ?? '',
        'Top of page bid' => $value['Top of page bid'] ?? '',
        'First position bid' => $value['First position bid'] ?? '',
        'Quality score' => $value['Quality score'] ?? '',
        'Landing page experience' => $value['Landing page experience'] ?? '',
        'Expected CTR' => $value['Expected CTR'] ?? '',
        'Ad relevance' => $value['Ad relevance'] ?? '',
        'Final URL' => $value['Final URL'] ?? '',
        'Final mobile URL' => $value['Final mobile URL'] ?? '',
        'Status' => $value['Status'] ?? '',
        'Approval Status' => $value['Approval Status'] ?? '',
        'Ad type' => $value['Ad type'] ?? '',
        'Headline 1' => $value['Headline 1'] ?? '',
        'Headline 1 position' => $value['Headline 1 position'] ?? '',
        'Headline 2' => $value['Headline 2'] ?? '',
        'Headline 2 position' => $value['Headline 2 position'] ?? '',
        'Headline 3' => $value['Headline 3'] ?? '',
        'Headline 3 position' => $value['Headline 3 position'] ?? '',
        'Headline 4' => $value['Headline 4'] ?? '',
        'Headline 4 position' => $value['Headline 4 position'] ?? '',
        'Headline 5' => $value['Headline 5'] ?? '',
        'Headline 5 position' => $value['Headline 5 position'] ?? '',
        'Headline 6' => $value['Headline 6'] ?? '',
        'Headline 6 position' => $value['Headline 6 position'] ?? '',
        'Headline 7' => $value['Headline 7'] ?? '',
        'Headline 7 position' => $value['Headline 7 position'] ?? '',
        'Headline 8' => $value['Headline 8'] ?? '',
        'Headline 8 position' => $value['Headline 8 position'] ?? '',
        'Headline 9' => $value['Headline 9'] ?? '',
        'Headline 9 position' => $value['Headline 9 position'] ?? '',
        'Headline 10' => $value['Headline 10'] ?? '',
        'Headline 10 position' => $value['Headline 10 position'] ?? '',
        'Headline 11' => $value['Headline 11'] ?? '',
        'Headline 11 position' => $value['Headline 11 position'] ?? '',
        'Headline 12' => $value['Headline 12'] ?? '',
        'Headline 12 position' => $value['Headline 12 position'] ?? '',
        'Headline 13' => $value['Headline 13'] ?? '',
        'Headline 13 position' => $value['Headline 13 position'] ?? '',
        'Headline 14' => $value['Headline 14'] ?? '',
        'Headline 14 position' => $value['Headline 14 position'] ?? '',
        'Headline 15' => $value['Headline 15'] ?? '',
        'Headline 15 position' => $value['Headline 15 position'] ?? '',
        'Description 1' => $value['Description 1'] ?? '',
        'Description 1 position' => $value['Description 1 position'] ?? '',
        'Description 2' => $value['Description 2'] ?? '',
        'Description 2 position' => $value['Description 2 position'] ?? '',
        'Description 3' => $value['Description 3'] ?? '',
        'Description 3 position' => $value['Description 3 position'] ?? '',
        'Description 4' => $value['Description 4'] ?? '',
        'Description 4 position' => $value['Description 4 position'] ?? '',
        'Path 1' => $value['Path 1'] ?? '',
        'Path 2' => $value['Path 2'] ?? '',
        'Ad strength' => $value['Ad strength'] ?? '',
        'Link Text' => $value['Link Text'] ?? '',
        'Description Line 1' => $value['Description Line 1'] ?? '',
        'Description Line 2' => $value['Description Line 2'] ?? '',
        'Device Preference' => $value['Device Preference'] ?? '',
    ];
}

$data = [];

$headers = [
    'Campaign', 'Labels', 'Budget', 'Budget type', 'Standard conversion goals', 'Custom conversion goal', 'Campaign Type', 'Networks', 'Location and language targeting', 'Location ID', 'Location', 'Languages', 'Bid Strategy Type', 'Bid Strategy Name', 'Enhanced CPC', 'Start Date', 'End Date', 'Ad Schedule', 'Ad rotation', 'Targeting method', 'Exclusion method', 'Audience targeting', 'Flexible Reach', 'Text asset automation', 'Final URL expansion', 'Campaign Status', 'Ad Group', 'Max CPC', 'Max CPM', 'Target CPA', 'Max CPV', 'Target CPV', 'Percent CPC', 'Target CPM', 'Target ROAS', 'Desktop Bid Modifier', 'Mobile Bid Modifier', 'Tablet Bid Modifier', 'TV Screen Bid Modifier', 'Display Network Custom Bid Type', 'Optimized targeting', 'Ad Group Type', 'Audience name', 'Age demographic', 'Gender demographic', 'Income demographic', 'Parental status demographic', 'Remarketing audience segments', 'Interest categories', 'Life events', 'Custom audience segments', 'Detailed demographics', 'Remarketing audience exclusions', 'Tracking template', 'Final URL suffix', 'Custom parameters', 'Ad Group Status', 'Comment', 'Callout text', 'Keyword', 'Criterion Type', 'First page bid', 'Top of page bid', 'First position bid', 'Quality score', 'Landing page experience', 'Expected CTR', 'Ad relevance', 'Final URL', 'Final mobile URL', 'Status', 'Approval Status', 'Ad type', 'Headline 1', 'Headline 1 position', 'Headline 2', 'Headline 2 position', 'Headline 3', 'Headline 3 position', 'Headline 4', 'Headline 4 position', 'Headline 5', 'Headline 5 position', 'Headline 6', 'Headline 6 position', 'Headline 7', 'Headline 7 position', 'Headline 8', 'Headline 8 position', 'Headline 9', 'Headline 9 position', 'Headline 10', 'Headline 10 position', 'Headline 11', 'Headline 11 position', 'Headline 12', 'Headline 12 position', 'Headline 13', 'Headline 13 position', 'Headline 14', 'Headline 14 position', 'Headline 15', 'Headline 15 position', 'Description 1', 'Description 1 position', 'Description 2', 'Description 2 position', 'Description 3', 'Description 3 position', 'Description 4', 'Description 4 position', 'Path 1', 'Path 2', 'Ad strength', 'Link Text', 'Description Line 1', 'Description Line 2', 'Device Preference'
];


$json = json_decode(file_get_contents('php://input'), true);

$insert = DB::insert('campaigns_header', [
    'file_path' => $json['file'],
    'file_text' => $json['file'],
]);

if($insert['statement']){

    foreach ($json['data'] as $key => $value) {

        $lang = array_filter($configLanguages, function($val) use($value){
            return strtolower($val['country']) == strtolower($value['COUNTRY']);
        });

        $lineCampaign = formatCampaignData([
            'Campaign' => $value['CAMPAIGN'],
            'Labels' => $value['LABEL'],
            'Budget' => $value['BUDGET'],
            'Budget type' => 'Daily',
            'Standard conversion goals' => '[]',
            'Custom conversion goal' => $value['CAMPAIGN'],
            'Campaign Type' => 'Search',
            'Networks' => 'Google search',
            'Location and language targeting' => 'Campaign level',
            'Location ID' => $lang[0]['id'],
            'Location' => $value['COUNTRY'],
            'Languages' => 'en;' . $lang[0]['code'],
            'Bid Strategy Type' => 'Manual CPC',
            'Enhanced CPC' => 'Disabled',
            'Start Date' => $value['INITIALDATE'],
            'End Date' => '[]',
            'Ad Schedule' => '[]',
            'Ad rotation' => 'Rotate indefinitely',
            'Targeting method' => 'Location of presence or Area of interest',
            'Exclusion method' => 'Location of presence',
            'Audience targeting' => 'Audience segments',
            'Flexible Reach' => 'Audience segments',
            'Text asset automation' => 'Disabled',
            'Final URL expansion' => 'Enabled',
            'Campaign Status' => 'Enabled',
        ]);

        array_push($data, $lineCampaign);

        $lineCampaign2 = formatCampaignData([
            'Campaign' => $value['CAMPAIGN'],
            'Languages' => 'All',
            'Ad rotation' => 'Rotate indefinitely',
            'Targeting method' => 'Location of presence or Area of interest',
            'Exclusion method' => 'Location of presence',
            'Audience targeting' => 'Audience segments',
            'Flexible Reach' => 'Audience segments;Genders;Ages;Parental status;Household incomes',
            'Text asset automation' => 'Disabled',
            'Final URL expansion' => 'Enabled',
            'Campaign Status' => 'Enabled',
            'Ad Group' => $value['CAMPAIGN'],
            'Max CPC' => $value['INITIALCPC'],
            'Max CPM' => '0.01',
            'Target CPV' => '0.01',
            'Desktop Bid Modifier' => '0',
            'Mobile Bid Modifier' => '0',
            'Tablet Bid Modifier' => '0',
            'Display Network Custom Bid Type' => 'None',
            'Optimized targeting' => 'Disabled',
            'Ad Group Type' => 'Standard',
            'Ad Group Status' => 'Enabled',
        ]);

        array_push($data, $lineCampaign2);

        $calloutArray = (array) translateCalloutText($client, $value['COUNTRY']);

        foreach($calloutArray as $calloutText){
            $calloutTextLine = formatCampaignData([
                'Campaign' => $value['CAMPAIGN'],
                'Ad Group' => $value['CAMPAIGN'],
                'Callout text' => $calloutText,
            ]);

            array_push($data, $calloutTextLine);
        }

        $listKeyWords = explode(',', $value['LISTKEYWORDS']);

        foreach ($listKeyWords as $keyword) {
            if(!empty($keyword)){

                $keywordsLine = formatCampaignData([
                    'Campaign' => $value['CAMPAIGN'],
                    'Campaign Status' => 'Enabled',
                    'Ad Group' => $value['CAMPAIGN'],
                    'Ad Group Status' => 'Enabled',
                    'Keyword' => trim($keyword),
                    'Criterion Type' => 'Broad',
                    'Status' => 'Enabled',
                    'Approval Status' => 'Enabled',
                ]);

                array_push($data, $keywordsLine);
            }            
        }

        $headLineCTAKeyWord = $value['CTAHEADLINE1'];

        $url = $value['URLNOTUTM'];

        $headLineExploded = explode(" ", $headLineCTAKeyWord);
        
        $headlines = ['-', 1, 2];

        foreach ($headlines as $keyHeadLine) {

            $cta = $client->sendMessage(
                "
                    Preciso que crie CTA (Headline), para meu anúncio no google. 
                    Tome Como base para criar a palavra: $headLineCTAKeyWord.
                    No idioma do artigo (sigla {$lang[0]['code']}).

                    Eu preciso de quatro CTA com até 4 palavras e no máximo 25 caracteres.  
                    Jamais pode passar desse número de palavras e caracteres, pois o google ads não aceita maior.
                "
            , 'Traga a resposta apenas como um array.');

            $cta = json_decode($cta['firstResponse'], true);

            $descriptions = $client->sendMessage(
                "
                    Preciso que crie quatro descrições para meu anúncio no google.
                    Tome Como base para criar a palavra: $headLineCTAKeyWord. 

                    No idioma do artigo (sigla {$lang[0]['code']}).
                    Eu preciso de quatro descrições com 12 palavras e no máximo 75 caracteres.

                    Jamais pode passar desse número de palavras e caracteres, pois o google ads não aceita maior.
                "
            , 'Traga a resposta apenas como um array.');

            $descriptions = json_decode($descriptions['firstResponse'], true);
            
            $queryParams = http_build_query([
                'utm_source' => $value['UTMSOURCE'],
                'utm_medium' => $value['UTMMEDIUM'],
                'utm_campaign' => $value['UTMCAMPAGIN'],
            ]);

            $finalUrl = "$url?$queryParams";

            $utmLine = formatCampaignData([
                'Campaign' => $value['CAMPAIGN'],
                'Campaign Status' => 'Enabled',
                'Ad Group' => $value['CAMPAIGN'],
                'Ad Group Status' => 'Enabled',
                'Final URL' => $finalUrl,
                'Status' => 'Enabled',
                'Ad type' => 'Responsive search ad',
                'Headline 1' => "{KeyWord:$headLineCTAKeyWord}",
                'Headline 1 position' => $keyHeadLine,
                'Headline 2' => $cta[0],
                'Headline 2 position' => $keyHeadLine,
                'Headline 3' => $cta[1],
                'Headline 3 position' => $keyHeadLine,
                'Headline 4' => $cta[2],
                'Headline 4 position' => $keyHeadLine,
                'Headline 5' => $cta[3],
                'Headline 5 position' => $keyHeadLine,
                'Headline 6' => $calloutArray[0],
                'Headline 6 position' => $keyHeadLine,
                'Headline 7' => $calloutArray[1],
                'Headline 7 position' => '-',
                'Headline 8' => $calloutArray[2],
                'Headline 8 position' => '-',
                'Headline 9' => $calloutArray[3],
                'Headline 9 position' => '-',
                'Headline 10' => $calloutArray[4],
                'Headline 10 position' => '-',
                'Headline 11' => $calloutArray[5],
                'Headline 11 position' => '-',
                'Headline 12' => $calloutArray[6],
                'Headline 12 position' => '-',
                'Headline 13' => $calloutArray[7],
                'Headline 13 position' => '-',
                'Headline 14' => $calloutArray[8],
                'Headline 14 position' => '-',
                'Headline 15' => $calloutArray[9],
                'Headline 15 position' => '-',
                'Description 1' => $descriptions[0],
                'Description 1 position' => '-',
                'Description 2' => $descriptions[1],
                'Description 2 position' => '-',
                'Description 3' => $descriptions[2],
                'Description 3 position' => '-',
                'Description 4' => $descriptions[3],
                'Description 4 position' => '-',
                'Path 1' => $headLineExploded[0],
                'Path 2' => end($headLineExploded),
                'Ad strength' => 'Average'
            ]);

            array_push($data, $utmLine);
        }

        $utmMaxLinks = 20;

        for ($i = 1; $i <= $utmMaxLinks; $i++) {

            $linkText = $client->sendMessage(
                "Preciso que crie duas CTA (Headline), para meu anúncio no google. Tome Como base para criar a palavra: $headLineCTAKeyWord. No idioma do artigo (sigla {$lang[0]['code']}). Eu preciso de quatro CTA com até 4 palavras e no máximo 25 caracteres. Jamais pode passar desse número de palavras e caracteres, pois o google ads não aceita maior."
            , 'Traga a resposta apenas como um array.');
    
            $linkText = json_decode($linkText['firstResponse'], true);

            $descriptionLines = $client->sendMessage(
                "Preciso que crie duas descrições para meu anúncio no google. Tome Como base para criar a palavra: $headLineCTAKeyWord. No idioma do artigo (sigla {$lang[0]['code']}). Eu preciso de quatro descrições com 12 palavras e no máximo 75 caracteres. Jamais pode passar desse número de palavras e caracteres, pois o google ads não aceita maior."
            , 'Traga a resposta apenas como um array.');
    
            $descriptionLines = json_decode($descriptionLines['firstResponse'], true);
            
            $prefix = $value['PREFIXSITELINK'];

            $id = str_pad($i, 2, 0, STR_PAD_LEFT);
            
            $queryParams = http_build_query([
                'utm_source' => $value['UTMSOURCE'],
                'utm_medium' => $value['UTMMEDIUM'],
                'utm_campaign' => "{$value['UTMCAMPAGIN']}_{$prefix}$id",
            ]);

            $finalUrl = "$url?$queryParams";

            $siteLinkLine = formatCampaignData([
                'Campaign' => $value['CAMPAIGN'],
                'Ad Group' => $value['CAMPAIGN'],
                'Final URL' => $finalUrl,
                'Link Text' => $linkText[0],
                'Description Line 1' => $descriptionLines[0],
                'Description Line 2' => $descriptionLines[1],
                'Device Preference' => 'All'
            ]);

            array_push($data, $siteLinkLine);
        }
        
        /* $insert = DB::insert('campaigns', [
            'header' => $insert['id'],
            'campaign' => $value['CAMPAIGN'],
            'group_campaign' => $value['GROUP'],
            'budget' => $value['BUDGET'],
            'typecampaign' => $value['TYPECAMPAIGN'],
            'initialcpc' => $value['INITIALCPC'],
            'country' => $value['COUNTRY'],
            'conversiongoal' => $value['CONVERSIONGOAL'],
            'initialdate' => $value['INITIALDATE'],
            'urlnotutm' => $value['URLNOTUTM'],
            'listkeywords' => $value['LISTKEYWORDS'],
            'wordsnotused' => $value['WORDSNOTUSED'],
            'ctaheadline1' => $value['CTAHEADLINE1'],
            'utmcampaign' => $value['UTMCAMPAGIN'],
            'utmmedium' => $value['UTMMEDIUM'],
            'label' => $value['LABEL'],
            'prefixsitelink' => $value['PREFIXSITELINK'],
            'csv_campaigns' => '0'
        ]); */
    }
}

$filename = 'campaign_data.csv';

$fp = fopen($filename, 'w');

fputcsv($fp, $headers);

foreach ($data as $row) {

    $csv_row = [];
    foreach ($headers as $header) {
        $csv_row[] = isset($row[$header]) ? $row[$header] : '';
    }
    fputcsv($fp, $csv_row);
}

fclose($fp);