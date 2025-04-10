<section class="reviews-section">
  <div class="reviews-heading">
    <h2>Recent Customer Reviews</h2>
  </div>
  
  <div class="reviews-grid">
    <?php
    // SQL statement
    $sql = "SELECT name, surname, rating, review FROM ciaoreviews ORDER BY review_id DESC LIMIT ?";

    // Create prepared statement
    $stmt = $conn->prepare($sql);

    // set query limit to 2, so only the 2 most recent reviews are shown
    $limit = 2;
    $stmt->bind_param("i", $limit);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Process the results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="review-card">
                <div class="review-body">
                    <p class="review-text"><?php echo htmlspecialchars($row["review"]); ?></p>
                    <div class="review-rating">
                        Rating: <?php echo htmlspecialchars($row["rating"]); ?> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f1c40f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon">
                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                        </svg>
                    </div>
                </div>
                <div class="review-footer">
                    <p class="review-author"><?php echo htmlspecialchars($row["name"] . " " . $row["surname"]); ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No reviews available at this time.</p>";
    }

    $stmt->close();
    ?>
  </div>
</section>