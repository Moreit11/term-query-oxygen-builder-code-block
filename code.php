<div class="taxonomy-grid">
    <?php
    // Function to get the term image URL for a given term ID
    function get_term_image_url($term_id) {
        // Replace 'your-custom-img-id' with your actual Meta Box field ID
        $images = rwmb_meta('your-custom-img-id', ['object_type' => 'term', 'size' => 'full'], $term_id);

        // Check if there are images and return the first image URL
        if (!empty($images)) {
            $image = reset($images);
            return esc_url($image['full_url']); // Use 'full_url' to get the original resolution
        } else {
            return '/wp-content/uploads/placeholder-image.webp'; // Return a default image URL if no image is found - replace this with an image of your choice
        }
    }

    // Specify the IDs you want to query
    $taxonomy_ids = array(2, 3, 26);

    // Loop through each ID and retrieve the corresponding taxonomy terms
    foreach ($taxonomy_ids as $term_id) {
        $term = get_term($term_id, 'your-taxonomy');
        
        // Check if the term exists
        if ($term && !is_wp_error($term)) {
            // Retrieve custom image field value
            $term_image_url = get_term_image_url($term_id);

            // Display child terms first
            $child_terms = get_terms(array(
                'taxonomy' => 'your-taxonomy',
                'parent' => $term_id,
            ));

            ?>
            <div class="taxonomy-card">
              <div class="taxonomy-card__overlay"> </div>
                <?php
                // Display term image for parent terms
                if (!empty($term_image_url)) {
                    ?>
                    <img class="taxonomy-card__img" src="<?php echo esc_url($term_image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                    <?php
                }
                
                // Display child terms
                if ($child_terms && !is_wp_error($child_terms)) {
                    ?>
                      <div class="taxonomy-card__content-wrap">
                      <ul class="child-terms-list">
                        <?php
                        foreach ($child_terms as $child_term) {
                            ?>
                            <li><a href="<?php echo get_term_link($child_term); ?>"><?php echo $child_term->name; ?></a></li>
                            <?php
                        }
                        ?>
                        <!-- View All item -->
                        <li><a href="<?php echo get_term_link($term); ?>">View all</a></li>
                    </ul>
                    <?php
                }

                // Add more content as needed
                ?>
                <h2 class="taxonomy-card__title"><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></h2>
            </div> <!-- Close taxonomy-card div -->
                      </div>
            <?php
          
        }
    }

    // Get all parent taxonomies for the 'your-taxonomy' taxonomy
    $parent_taxonomies = get_terms(array(
        'taxonomy' => 'your-taxonomy',
        'parent' => 0,
        'exclude' => $taxonomy_ids,
    ));

    // Output the "Other Specialities" card if there are parent taxonomies
    if ($parent_taxonomies && !is_wp_error($parent_taxonomies)) {
        ?>
        <div class="taxonomy-card specialities-card">
          <div class="taxonomy-card__overlay"> </div>
      <img class="taxonomy-card__img" src="/wp-content/uploads/replace-with-your-image-url.webp" alt="other specialities">      <!--  replace this image url with the image url you would like to use for the 4th grid element-->
      <div class="taxonomy-card__content-wrap"> 
          <ul class="specialities-list">
                <?php
                // Output the list of other parent taxonomies
                foreach ($parent_taxonomies as $parent_taxonomy) {
                    // Retrieve custom image field value for parent terms
                    $parent_term_image_url = get_term_image_url($parent_taxonomy->term_id);

                    ?>
                    <li>
                        <a href="<?php echo get_term_link($parent_taxonomy); ?>"><?php echo $parent_taxonomy->name; ?></a>
                    </li>
                    <?php
                }
                // View All item
                ?>
                <li><a href="/replace-with-your-slug/">View all</a></li>
            </ul>
            <h2 class="taxonomy-card__title"><a href="/replace-with-your-slug/">Other Specialities</a></h2>
        </div>
                      </div>
        <?php
    }
    ?>
</div>
    ?>
</div>
