<?php

class themifier_walker_category extends Walker_Category
{
    /**
     * {@inheritDoc}
     */
    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
        if (!empty($args['show_count']) && !empty($args['count_wrap'])) {
            $args['show_count'] = false;

            parent::start_el($out, $category, $depth, $args, $id);
            $out = rtrim($out);

            // remove any trailing <br /> tag
            $out = preg_replace('#<br\s*/?>#i', '', $out);

            // prepare format for item count, both %s and {count} can be placeholders
            $count_format = strtr($args['count_wrap'], array('{count}' => '%s'));
            $count = sprintf($count_format, number_format_i18n($category->count));

            if (!empty($args['count_inside_link'])) {
                $out = str_ireplace('</a>', '', $out) . $count . '</a>';
            } else {
                $out .= $count;
            }

            $out .= ('list' === $args['style'] ? '' : '<br />') . "\n";

            $output .= $out;
            return;
        }

        parent::start_el($output, $category, $depth, $args, $id);
    }
}
