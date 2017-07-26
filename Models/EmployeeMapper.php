<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types=1);
namespace Modules\HumanResourceManagement\Models;

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

class EmployeeMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'hr_staff_id'         => ['name' => 'hr_staff_id', 'type' => 'int', 'internal' => 'id'],
        'hr_staff_account'     => ['name' => 'hr_staff_account', 'type' => 'int', 'internal' => 'account'],
    ];

    protected static $ownsOne = [
        'account' => [
            'mapper'         => AccountMapper::class,
            'src'            => 'hr_staff_account',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'hr_staff_id';
}
