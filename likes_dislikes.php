<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'forum_db';

// Connect to the database

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Get the post ID from the request parameters
$post_id = $_GET['topic_id'];

// Calculate the number of upvotes for the post
$sql = "SELECT COUNT(*) AS upvotes FROM votes WHERE topic_id = ? AND vote_type = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$post_id]);
$upvotes = $stmt->fetch(PDO::FETCH_ASSOC)['upvotes'];

// Calculate the number of downvotes for the post
$sql = "SELECT COUNT(*) AS downvotes FROM votes WHERE topic_id = ? AND vote_type = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute([$post_id]);
$downvotes = $stmt->fetch(PDO::FETCH_ASSOC)['downvotes'];
?>

<script>
// Handle upvote button click
$('.upvote').click(function() {
    var post_id = $(this).data('topic_id');
    $.ajax({
      type: 'GET',
      url: 'view_forum.php',
      data: { post_id: post_id, vote_type:1 },
      success: function(data) {
        // Update the score value
        $('.post[data-postid=' + post_id + '] .score-value').text(data);
      }
    });
  });
  
  // Handle downvote button click
  $('.downvote').click(function() {
    var post_id = $(this).data('postid');
    $.ajax({
      type: 'GET',
      url: 'view_forum.php',
      data: { post_id: post_id, vote_type:0},
      success: function(data) {
        // Update the score value
        $('.post[data-postid=' + post_id + '] .score-value').text(data);
      }
    });
  });
</script>
  

