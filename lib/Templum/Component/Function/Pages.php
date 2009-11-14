<?php
/**
 * Show variable or set specified value.
 *
 * Parameters:
 *  - total: count of all available pages
 *  - center: count of pages shown in center (optional)
 *  - page: current page number (optional)
 *  - class: css class name for pages block (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Function_Pages implements Templum_Component_Function_Abstract {
    protected $_required = array('total', 'center', 'page');

    /**
     * Return result of current helper.
     *
     * @param array $params: 0 - all pages, 1 - count of show links in center, 2 - current page
     */
    protected function _handle(array $params=array()) {
        // set correct params
        $totalPages   = ((isset($params['total'])  AND $params['total']>0)  ? $params['total']  : 1);
        $centerPages  = ((isset($params['center']) AND $params['center']>0) ? $params['center'] : 3);
        $currentPage  = ((isset($params['page'])   AND $params['page']>0)   ? $params['page']   : 1);
        $cssClassName = (isset($params['class']) ? $params['class'] : 'pages');
        // set additional parameters
        $startPage = $currentPage - (int)($centerPages/2);
        $endPage   = $currentPage + (int)($centerPages/2);
        // prepare params
        if ($startPage < 1) {
            $endPage = $endPage + (1 - $startPage);
            $startPage = 1;
        }
        if ($endPage > $totalPages) {
            $startPage = $startPage - ($endPage - $totalPages);
            $endPage = $totalPages;
        }
        if ($startPage < 1)
            $startPage = 1;
        // current page not real
        if ($currentPage > $totalPages)
            $currentPage = $totalPages;
        // print pages
        return $this->_getPagesLinks($totalPages, $currentPage, $startPage, $endPage, '<', '>', ' ', '', $cssClassName);
    }

    /**
     * Return html code of pages links.
     *
     * @param int $totalPages
     * @param int $currentPage
     * @param int $startPage
     * @param int $endPage
     * @param string $prevText
     * @param string $nextText
     * @param string $delimiter
     * @param string $baseUrl
     * @param string $cssClass
     * @return string
     */
    private function _getPagesLinks($totalPages, $currentPage, $startPage, $endPage, $prevText='', $nextText='', $delimiter='', $baseUrl='', $cssClass='pages') {
        // result links
        $links     = array();
        // prepare parameters
        $prevPage  = $currentPage - 1;
        $nextPage  = $currentPage + 1;
        $prevText  = htmlentities($prevText);
        $nextText  = htmlentities($nextText);
        $delimiter = htmlentities($delimiter);
        // set correct base path
        if (! empty ($baseUrl))
            $baseUrl = rtrim($baseUrl, '/') . '/';
        // start navigation block
        $links[] = "<div class='{$cssClass}'>";
        // set link to first page
        if ($startPage > 1)
            $links[] = "<a class='page first' href='{$baseUrl}1'>1</a>";
        // set link to previous page
        if ('' != $prevText AND $prevPage > 1)
            $links[] = "<a class='page prev' href='{$baseUrl}{$prevPage}'>{$prevText}</a>";
        // set center links
        for ($iPageNum=$startPage; $iPageNum<=$endPage; $iPageNum++) {
            $cssClassSelected = (($iPageNum==$currentPage) ? 'page selected' : 'page');
            $links[] = "<a class='{$cssClassSelected}' href='{$baseUrl}{$iPageNum}'>{$iPageNum}</a>";
        }
        // set link to next page
        if ('' != $nextText AND $nextPage < $totalPages)
            $links[] = "<a class='page next' href='{$baseUrl}{$nextPage}'>{$nextText}</a>";
        // set link to last page
        if ($endPage < $totalPages)
            $links[] = "<a class='page last' href='{$baseUrl}{$totalPages}'>{$totalPages}</a>";
        // end navigation block
        $links[] = '</div>';
        // return links
        return implode("{$delimiter}\n", $links);
    }
}