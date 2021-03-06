<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\tests\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;

/**
 * @internal
 */
class EmployeeMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\HumanResourceManagement\Models\EmployeeMapper
     * @group module
     */
    public function testCR() : void
    {
        if (($profile = ProfileMapper::getFor(1, 'account'))->getId() === 0) {
            $profile = new Profile();

            $profile->account  = AccountMapper::get(1);
            $profile->birthday = ($date = new \DateTime('now'));

            $id = ProfileMapper::create($profile);
        }

        $employee = new Employee($profile);

        $id = EmployeeMapper::create($employee);
        self::assertGreaterThan(0, $employee->getId());
        self::assertEquals($id, $employee->getId());

        $employeeR = EmployeeMapper::get($employee->getId());
        self::assertEquals($employee->profile->getId(), $employeeR->profile->getId());
    }
}
