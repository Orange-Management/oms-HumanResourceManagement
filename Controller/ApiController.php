<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\HumanResourceManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Controller;

use Modules\Admin\Models\Account;
use Modules\HumanResourceManagement\Models\Employee;
use Modules\HumanResourceManagement\Models\EmployeeHistory;
use Modules\HumanResourceManagement\Models\EmployeeHistoryMapper;
use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;

/**
 * HumanResourceManagement controller class.
 *
 * @package Modules\HumanResourceManagement
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create an employee from an existing account
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if ($request->getData('profiles') !== null) {
            $this->apiEmployeeFromAccountCreate($request, $response, $data);

            return;
        }

        $this->apiEmployeeNewCreate($request, $response, $data);
    }

    /**
     * Api method to create an employee from an existing account
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeFromAccountCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeFromAccountCreate($request))) {
            $response->set('employee_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $employees = $this->createEmployeeFromAccountFromRequest($request);
        $this->createModels($request->header->account, $employees, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Employee', 'Employee(s) successfully created', $employees);
    }

    /**
     * Validate employee from profile create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeFromAccountCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['profiles'] = empty($request->getData('profiles')))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create employee from profile from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Employee[]
     *
     * @since 1.0.0
     */
    private function createEmployeeFromAccountFromRequest(RequestAbstract $request) : array
    {
        $accounts  = $request->getDataList('profiles') ?? [];
        $employees = [];

        foreach ($accounts as $account) {
            /** @var Profile $profile Profile */
            $profile     = ProfileMapper::getFor((int) $account, 'account');
            $employees[] = new Employee($profile);
        }

        return $employees;
    }

    /**
     * Api method to create a new employee
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeNewCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeNewCreate($request))) {
            $response->set('employee_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $employee = $this->createEmployeeNewFromRequest($request);
        $this->createModel($request->header->account, $employee, EmployeeMapper::class, 'employee', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Employee', 'Employee successfully created', $employee);
    }

    /**
     * Validate employee create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeNewCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name1'] = empty($request->getData('name1')))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create a new employee from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Employee
     *
     * @since 1.0.0
     */
    private function createEmployeeNewFromRequest(RequestAbstract $request) : Employee
    {
        $account        = new Account();
        $account->name1 = (string) ($request->getData('name1') ?? '');
        $account->name2 = (string) ($request->getData('name2') ?? '');
        $account->name3 = (string) ($request->getData('name3') ?? '');
        $account->name3 = (string) ($request->getData('email') ?? '');

        $profile           = new Profile($account);
        $profile->birthday = new \DateTime((string) ($request->getData('birthday') ?? 'now'));

        $employee = new Employee($profile);

        return $employee;
    }

    /**
     * Api method to create an employee history
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEmployeeHistoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateEmployeeHistoryCreate($request))) {
            $response->set('history_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $history = $this->createEmployeeHistoryFromRequest($request);
        $this->createModel($request->header->account, $history, EmployeeHistoryMapper::class, 'history', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'History', 'History successfully created', $history);
    }

    /**
     * Validate employee history
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEmployeeHistoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['employee'] = empty($request->getData('employee')))
            || ($val['start'] = empty($request->getData('start')))
            || ($val['unit'] = empty($request->getData('unit')))
            || ($val['department'] = empty($request->getData('department')))
            || ($val['position'] = empty($request->getData('position')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create employee history from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return EmployeeHistory
     *
     * @since 1.0.0
     */
    private function createEmployeeHistoryFromRequest(RequestAbstract $request) : EmployeeHistory
    {
        $history = new EmployeeHistory((int) ($request->getData('employee') ?? 0));
        $history->setUnit((int) ($request->getData('unit') ?? 0));
        $history->setDepartment((int) ($request->getData('department') ?? 0));
        $history->setPosition((int) ($request->getData('position') ?? 0));
        $history->setStart(new \DateTime($request->getData('start') ?? 'now'));

        if (!empty($request->getData('end'))) {
            $history->setEnd(new \DateTime($request->getData('end')));
        }

        return $history;
    }
}
