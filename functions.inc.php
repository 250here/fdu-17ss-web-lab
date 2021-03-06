<?php

function generateLink($url, $label, $class) {
   $link = '<a href="' . $url . '" class="' . $class . '">';
   $link .= $label;
   $link .= '</a>';
   return $link;
}


function outputPostRow($number)  {
    include("travel-data.inc.php");
	$content = '<div class="row"><div class="col-md-4">';
	$content .= generateLink("post.php?id=" . ${"postId" . $number},constructImage("images/" . ${"thumb" . $number},${"title" . $number}),"");
	$content .= '</div><div class="col-md-8">';
	$content .= '<h2>' . ${"title" . $number} . '</h2>';
	$content .= '<div class="details">Posted by ' . generateLink('user.php?id=' . ${"userId" . $number},${"userName" . $number},'') . '<span class="pull-right">' . ${"date" . $number} . '</span>';
	$content .= '<p>' . constructRating(${"reviewsRating" . $number}) . ' ' . ${"reviewsNum" . $number} . ' Reviews</p></div>';
	$content .= '<p class="excerpt">' . ${"excerpt" . $number} . '</p>';
	$content .= '<p>' . generateLink("post.php?id=" . ${"postId" . $number},'Read more','btn btn-primary btn-sm') . '</p>';
	$content .= '</div>';
	$content .= '</div><hr>';
	echo $content;
}

/*
  Function constructs a string containing the <img> tags necessary to display
  star images that reflect a rating out of 5
*/
function constructRating($rating) {
    $imgTags = "";
    
    // first output the gold stars
    for ($i=0; $i < $rating; $i++) {
        $imgTags .= '<img src="images/star-gold.svg" width="16" />';
    }
    
    // then fill remainder with white stars
    for ($i=$rating; $i < 5; $i++) {
        $imgTags .= '<img src="images/star-white.svg" width="16" />';
    }    
    
    return $imgTags;    
}

function constructImage($src,$alt){
	$image='<img src="' . $src . '" alt="' . $alt . '" class="img-responsive">';;
	return $image;
}

?>