<?php

$block_name = _("Overview");

/**
 * Ingo_Filters_Block:: implementation of the Horde_Block API to show filter
 * information on the portal.
 *
 * See the enclosed file LICENSE for license information (ASL).  If you
 * did not receive this file, see http://www.horde.org/licenses/asl.php.
 *
 * @author  Oliver Kuhl <okuhl@netcologne.de>
 * @package Horde_Block
 */
class Horde_Block_ingo_overview extends Horde_Block
{
    protected $_app = 'ingo';

    /**
     * The title to go in this block.
     *
     * @return string   The title text.
     */
    protected function _title()
    {
        return Horde::url($GLOBALS['registry']->getInitialPage(), true)->link() . $GLOBALS['registry']->get('name') . '</a>';
    }

    /**
     * The content to go in this block.
     *
     * @return string   The content
     */
    protected function _content()
    {
        /* Get list of filters */
        $filters = $GLOBALS['ingo_storage']->retrieve(Ingo_Storage::ACTION_FILTERS);
        $html = '<table width="100%" height="100%">';
        $html_pre = '<tr><td valign="top">';
        $html_post = '</td></tr>';
        foreach ($filters->getFilterList() as $filter) {
            if (!empty($filter['disable'])) {
                $active = _("inactive");
            } else {
                $active = _("active");
            }

            switch($filter['name']) {
            case 'Vacation':
                if (in_array(Ingo_Storage::ACTION_VACATION, $_SESSION['ingo']['script_categories'])) {
                    $html .= $html_pre .
                        Horde::img('vacation.png', _("Vacation")) .
                        '</td><td>' .
                        Horde::url('vacation.php')->link(array('title' => _("Edit"))) .
                        _("Vacation") . '</a> ' . $active . $html_post;
                }
                break;

            case 'Forward':
                if (in_array(Ingo_Storage::ACTION_FORWARD, $_SESSION['ingo']['script_categories'])) {
                    $html .= $html_pre .
                        Horde::img('forward.png', _("Forward")) . '</td><td>' .
                        Horde::url('forward.php')->link(array('title' => _("Edit"))) .
                        _("Forward") . '</a> ' . $active;
                    $data = unserialize($GLOBALS['prefs']->getValue('forward'));
                    if (!empty($data['a'])) {
                        $html .= ':<br />' . implode('<br />', $data['a']);
                    }
                    $html .= $html_post;
                }
                break;

            case 'Whitelist':
                if (in_array(Ingo_Storage::ACTION_WHITELIST, $_SESSION['ingo']['script_categories'])) {
                    $html .= $html_pre .
                        Horde::img('whitelist.png', _("Whitelist")) .
                        '</td><td>' .
                        Horde::url('whitelist.php')->link(array('title' => _("Edit"))) .
                        _("Whitelist") . '</a> ' . $active . $html_post;
                }
                break;

            case 'Blacklist':
                if (in_array(Ingo_Storage::ACTION_BLACKLIST, $_SESSION['ingo']['script_categories'])) {
                    $html .= $html_pre .
                        Horde::img('blacklist.png', _("Blacklist")) .
                        '</td><td>' .
                        Horde::url('blacklist.php')->link(array('title' => _("Edit"))) .
                        _("Blacklist") . '</a> ' . $active . $html_post;
                }
                break;

            case 'Spam Filter':
                if (in_array(Ingo_Storage::ACTION_SPAM, $_SESSION['ingo']['script_categories'])) {
                    $html .= $html_pre .
                        Horde::img('spam.png', _("Spam Filter")) .
                        '</td><td>' .
                        Horde::url('spam.php')->link(array('title' => _("Edit"))) .
                        _("Spam Filter") . '</a> ' . $active . $html_post;
                }
                break;
            }

        }

        return $html . '</table>';
    }

}
