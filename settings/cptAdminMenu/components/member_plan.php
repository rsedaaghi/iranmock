<?php
// Add custom columns to Member Plan admin list
add_filter('manage_member_plan_posts_columns', 'member_plan_columns');
function member_plan_columns($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['label'] = __('Label');
            $new_columns['exam_category'] = __('Exam Category');
            $new_columns['is_active'] = __('Is Active?');
        }
    }
    return $new_columns;
}

// Populate custom column content
add_action('manage_member_plan_posts_custom_column', 'member_plan_column', 10, 2);
function member_plan_column($column, $post_id)
{
    switch ($column) {
        case 'label':
            $label = get_field('label', $post_id);
            echo $label ? esc_html($label) : '—';
            break;

        case 'exam_category':
            $term_id = get_field('exam_category', $post_id);
            if ($term_id) {
                $term = get_term($term_id, 'exam_category');
                echo $term && !is_wp_error($term) ? esc_html($term->name) : '—';
            } else {
                echo '—';
            }
            break;

        case 'is_active':
            $is_active = get_field('is_active', $post_id);
            echo $is_active ? '✅ Yes' : '❌ No';
            break;
    }
}

// Make columns sortable
add_filter('manage_edit-member_plan_sortable_columns', 'member_plan_sortable_columns');
function member_plan_sortable_columns($columns)
{
    $columns['label'] = 'label';
    $columns['is_active'] = 'is_active';
    $columns['exam_category'] = 'exam_category';
    return $columns;
}

// Handle sorting logic
add_action('pre_get_posts', 'member_plan_orderby');
function member_plan_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    // Sort by label (ACF text field)
    if ($query->get('orderby') === 'label') {
        $query->set('meta_key', 'label');
        $query->set('orderby', 'meta_value');
    }

    // Sort by is_active (ACF true/false field)
    if ($query->get('orderby') === 'is_active') {
        $query->set('meta_key', 'is_active');
        $query->set('orderby', 'meta_value');
    }

    // Sort by exam_category (ACF taxonomy field returning Term ID)
    if ($query->get('orderby') === 'exam_category') {
        $query->set('meta_key', 'exam_category');
        $query->set('orderby', 'meta_value');
    }
}
