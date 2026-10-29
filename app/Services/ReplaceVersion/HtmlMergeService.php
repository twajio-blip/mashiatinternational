<?php

namespace App\Services\ReplaceVersion;

class HtmlMergeService
{
    /**
     * Merge the new HTML version with old dynamic Blade variables
     * 
     * @param string $oldHtml
     * @param string $newHtml
     * @return string
     */
    public function mergeHtmlKeepingDynamicData($oldHtml, $newHtml)
    {
        // Regular expression to find Blade dynamic data (e.g., {{$moredata}})
        $pattern = '/\{\{[^\}]+\}\}/';
        
        // Match all dynamic Blade data in the old HTML
        preg_match_all($pattern, $oldHtml, $dynamicDataMatches);
        
        // Load the new HTML into DOMDocument
        $newDom = new \DOMDocument();
        @$newDom->loadHTML($newHtml);

        // Get all elements in the new HTML
        $newElements = $newDom->getElementsByTagName('*');

        $counter = 0;

        foreach ($newElements as $newElement) {
            // Ensure that we replace dynamic content only in the body elements (not in the head/meta part)
            if ($newElement->tagName !== 'html' && $newElement->tagName !== 'body') {
                // Insert the old dynamic content into the new element
                if (isset($dynamicDataMatches[0][$counter])) {
                    $newElement->nodeValue = $dynamicDataMatches[0][$counter];
                    $counter++;
                }
            }
        }

        // Return the modified HTML with dynamic Blade variables restored
        return $newDom->saveHTML();
    }
}
