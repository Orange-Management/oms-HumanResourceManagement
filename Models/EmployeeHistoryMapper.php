<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Models;

use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\PositionMapper;
use Modules\Organization\Models\UnitMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * EmployeHistory mapper class.
 *
 * @package Modules\HumanResourceManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class EmployeeHistoryMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'hr_staff_history_id'         => ['name' => 'hr_staff_history_id',         'type' => 'int',      'internal' => 'id'],
        'hr_staff_history_staff'      => ['name' => 'hr_staff_history_staff',      'type' => 'int',      'internal' => 'employee'],
        'hr_staff_history_unit'       => ['name' => 'hr_staff_history_unit',       'type' => 'int',      'internal' => 'unit'],
        'hr_staff_history_department' => ['name' => 'hr_staff_history_department', 'type' => 'int',      'internal' => 'department'],
        'hr_staff_history_position'   => ['name' => 'hr_staff_history_position',   'type' => 'int',      'internal' => 'position'],
        'hr_staff_history_start'      => ['name' => 'hr_staff_history_start',      'type' => 'DateTime', 'internal' => 'start'],
        'hr_staff_history_end'        => ['name' => 'hr_staff_history_end',        'type' => 'DateTime', 'internal' => 'end'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'unit'    => [
            'mapper'     => UnitMapper::class,
            'external'   => 'hr_staff_history_unit',
        ],
        'department'    => [
            'mapper'     => DepartmentMapper::class,
            'external'   => 'hr_staff_history_department',
        ],
        'position'    => [
            'mapper'     => PositionMapper::class,
            'external'   => 'hr_staff_history_position',
        ],
        'employee'    => [
            'mapper'     => EmployeeMapper::class,
            'external'   => 'hr_staff_history_staff',
        ],
    ];

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'hr_staff_history_id';

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'hr_staff_history';
}
