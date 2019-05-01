<?php


namespace BthnTx;


use Exception;

final class teaser
{

    /**
     * makeTeaser returns a cleanly truncated teaser string from the
     * beginning of the article along with a link to
     * the full article. Truncation will follow the following Rules...
     * Truncation preferably happens at the nearest white space character
     * (space, newline, tab) or
     * punctuation character (comma, fullstop, colon, semicolon,
     * exclamation) that is less than maxLength specified.
     *
     * Additional Information:
     * All characters are single byte latin-1 characters.
     * Content is expected to be in plain text, please assume that there
     * are no HTML or SGML tags.
     * Unclear how safe $linkText and $url are
     *
     * Example
     * Content:
     * I quickly learned how fishy this world could be. A client I knew who
     * specialized in auto loans invited me up to his desk to show me how
     * to structure subprime debt. Eager to please, I promised I could
     * enhance my software to model his deals in less than a month. But when
     * I glanced at the takeout in the deal, I couldn't believe my eyes.
     *
     * Teaser:
     * I quickly learned how fishy this world could be. A client I knew who
     * specialized in auto loans invited me up to his desk to show me how
     * to structure subprime debt. Eager to please, I
     *
     * @param $content - String, Full/Partial Content of the article
     * @param $url - String, Absolute URL to the Full article
     * @param $linkText - String, Text to show for the link
     * @param $minLength - Number, Preferred minimum length of the teaser
     * (non binding)
     * @param $maxLength - Number, Maximum length of the teaser, optional. * If not set, maxLength = minLength+50
     * @return string Teaser That will be displayed
     * @throws Exception
     */


    static function makeTeaser($content, $url, $linkText, $minLength, $maxLength = null): string
    {

        if (empty($content)) {
            throw new Exception('Empty content.');
        }

        if (substr($url,0,4)!=="http"){
            throw new Exception('URL not absolute.');
        }

        if ($maxLength !== null && $maxLength < $minLength) {
            throw new Exception('Max length shorter than min length.');
        }


        $teaserMaxLength = ($maxLength === null) ? $minLength + 50 : $maxLength;
        $teaserMaxLength -=(strlen($teaserMaxLength)+1);

        if (strlen($content) <= $teaserMaxLength) {
            return $content;
        }

        $cutContent = substr($content, 0, $teaserMaxLength);
        $teaser = strrev($cutContent);


        $teaser = strpbrk($teaser, " \r\n\t,.:;?!");
        if (!$teaser) {
            throw new Exception('Teaser is continuous.');
        }


        //Dont break numbers like 3,001 or 3.5 3:5
        while (is_numeric($teaser[1]) && (is_numeric($content[strlen($teaser)]))) {
            $teaser = strpbrk(substr($teaser, 1), " \r\n\t,.:;?!");
            if (strlen($teaser) < 2) {
                throw new Exception('Continuous number inside.');
            }
        }
        $teaser = strrev($teaser);
        $teaser = trim($teaser);
        //simple URL escaping to avoid quotes and tags
        $_url = (htmlspecialchars($url));
        $_linkText = strip_tags($linkText);
        return "{$teaser} <a href=\"{$_url}\">{$_linkText}</a>";

    }


}
