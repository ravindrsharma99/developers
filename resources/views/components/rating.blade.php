<?php 
    $rating = isset($rating) ? $rating : 0;
    $averageRating = round($rating);
?>
<span class="star-rating" style="font-size: 25px;margin-top: 10px;" title="Rating {{$rating}} stars">
    @for($i = 1; $i <= 5 ; $i++)
    <i class=" fa  none {{$i <= $averageRating ? 'fa-star' : 'fa-star-o'}} " aria-hidden="true"></i>
    @endfor
</span>