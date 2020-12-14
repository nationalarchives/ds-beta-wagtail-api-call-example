<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $api_url = 'https://ds-beta-wagtail-example.herokuapp.com/api/v2/pages/4/?format=json';
    $data = file_get_contents($api_url);
    $blog_post = json_decode($data, true);

    $title = $blog_post["title"];
    $image = $blog_post["image"]["meta"]["download_url"];
    $date_published = $blog_post["date_published"];

    $subtitle = $blog_post["subtitle"];


    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/navi.0.0.4.css" />
    <title><?php echo $title ?></title>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "<?php echo $title ?>",
            "image": [
                "<?php echo $image ?>"
            ],
            "datePublished": "<?php echo $date_published ?>",
            "dateModified": "<?php echo $date_published ?>"
        }
    </script>

</head>

<?php

function echo_via_type($body_element)
{
    $value = $body_element["value"];
    $type = $body_element["type"];

    switch ($type) {
        case "paragraph_block":
            echo "<p>" . $value . "</p>";
            break;
        case "heading_block":
            $heading_size = $value["size"];
            $heading_text = $value["heading_text"];
            echo "<$heading_size>$heading_text</$heading_size>";
            break;
        case "block_quote":
            $quote = $value["text"];
            $author = $value["attribute_name"];
            echo "<blockquote>\"$quote\" <br/> - $author </blockquote>";
            break;
        case "embed_block":
            $embed_url = $body_element["value"];
            $embed_url = $pieces = explode("watch?v=", $embed_url)[1];
            $embed_url = "https://youtube.com/embed/" . $embed_url;
            echo '<iframe width="560" height="315" src="' . $embed_url . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            break;
    }
}
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <main>
                    <img src="/img/tna-square-logo.svg" id="logo" alt="The National Archives Square Logo">
                    <p><a href="https://nationalarchives.gov.uk">Home</a> > <a href="#">Blog</a> > <?php echo $title ?> </p>
                    <img src='<?php echo $image ?>' />
                    <article>
                        <h1><?php echo ($blog_post["title"]) ?></h1>
                        <p id="subtitle"><?php echo $subtitle ?></p>
                        <?php foreach ($blog_post["body"] as $key => $body_element) {
                            echo_via_type($body_element);
                        } ?>
                    </article>
                </main>
            </div>
        </div>
    </div>

</body>

</html>