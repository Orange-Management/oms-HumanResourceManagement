<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\HumanResourceManagement
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Modules\HumanResourceManagement\Controller;

use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;

use Modules\HumanResourceManagement\Models\EmployeeMapper;
use Modules\Organization\Models\DepartmentMapper;

/**
 * Human Resources controller class.
 *
 * @package    Modules\HumanResourceManagement
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class BackendController extends Controller
{

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response));

        $view->setData('employees', EmployeeMapper::getAll());

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response));

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrStaffProfile(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/staff-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1002402001, $request, $response));

        $employee = EmployeeMapper::get((int) $request->getData('id'));

        $view->addData('employee', $employee);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewHrDepartmentList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/HumanResourceManagement/Theme/Backend/department-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1002403001, $request, $response));

        $view->setData('departments', DepartmentMapper::getAll());

        return $view;
    }
}
