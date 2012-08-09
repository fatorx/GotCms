<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category    Gc
 * @package     Library
 * @subpackage  View
 * @author      Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license     GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link        http://www.got-cms.com
 */

namespace Gc\Media\Icon;

use Gc\Db\AbstractTable,
    Gc\Component\IterableInterface;
/**
 * Class for manage View
 */
class Model extends AbstractTable
{
    /**
     * Table name
     * @var string
     */
    protected $_name = 'icon';

    /**
     * Initiliaze from array
     * @param array $array
     * @return \Gc\Media\Icon\Model
     */
    static function fromArray(array $array)
    {
        $icon_table = new Model();
        $icon_table->setData($array);

        return $icon_table;
    }

    /**
     * Initiliaze from id
     * @param integer $id
     * @return \Gc\Media\Icon\Model
     */
    static function fromId($id)
    {
        $icon_table = new Model();
        $row = $icon_table->select(array('id' => $id));
        $current = $row->current();
        if(!empty($current))
        {
            return $icon_table->setData((array)$current);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Save icon
     * @return integer
     */
    public function save()
    {
        $array_save = array(
            'name' => $this->getName(),
            'url' => $this->getIdentifier(),
        );

        try
        {
            $id = $this->getId();
            if($this->getId() == NULL)
            {
                $this->insert($array_save);
                $this->setId($this->getLastInsertId());
            }
            else
            {
                $this->update($array_save, 'id = '.(int)$this->getId());
            }

            return $this->getId();
        }
        catch (Exception $e)
        {
            /**
             * TODO(Make \Gc\Error)
             */
            \Gc\Error::set(get_class($this), $e);
        }

        return FALSE;
    }

    /**
     * Delete icon
     * @return boolean
     */
    public function delete()
    {
        $id = $this->getId();
        if(!empty($id))
        {
            if(parent::delete(sprintf('id = %d', $id)))
            {
                unset($this);
                return TRUE;
            }
        }

        return FALSE;
    }
}
