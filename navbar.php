<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                
                    <li class="app-sidebar__heading">Home</li>
                    <li><a href="home.php"><i class="metismenu-icon pe-7s-portfolio">
                        </i>Home</a></li>
                    

                <?php 
                
                if($_SESSION['user_login_status']['rol'] == 2 || $_SESSION['user_login_status']['rol'] == 1){
                    ?>
                <li class="app-sidebar__heading">Setting</li>
                <li>
                    <a href="tools.php">
                        <i class="metismenu-icon pe-7s-tools"></i>
                     Tools
                    </a>
                </li>


                <li class="app-sidebar__heading">Reports</li>
                <li>
                    <a href="#" aria-expanded="false">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Reports
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-collapse" style="">
                    <li>
                    <a href="generate_1099.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        1099
                    </a>
                    <a href="generate_1055.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        1055
                    </a>
                    <a href="employee_by_staff.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        Employee by Staff Company
                    </a>
                    <a href="employee_certificate.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        Employee certificate
                    </a>
                    <a href="payroll_admin.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        Payroll employee
                    </a>
                  
                    <? if($_SESSION['user_login_status']['rol'] == 1){ ?>
                       
                        <a href="auditoria.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        Logs Audit
                        </a>

                    <? } ?>
                </li>
                    </ul>
                </li>






                <li>
                    <a href="employees.php">
                        <i class="metismenu-icon pe-7s-users"></i>
                     Employees
                    </a>
                </li>
                <li>
                    <a href="administrators.php">
                        <i class="metismenu-icon pe-7s-users"></i>
                     Administrators
                    </a>
                </li>
                <li>
                    <a href="host_company.php">
                        <i class="metismenu-icon pe-7s-network"></i>
                     Host company
                    </a>
                </li>

                <li>
                    <a href="work_place.php">
                        <i class="metismenu-icon pe-7s-news-paper"></i>
                        Work place
                    </a>
                </li>

                <li>
                    <a href="staff_company.php">
                        <i class="metismenu-icon pe-7s-users"></i>
                     Staff company
                    </a>
                </li>

                <li>
                    <a href="upload_payroll.php">
                        <i class="metismenu-icon pe-7s-upload"></i>
                        Upload Payroll
                    </a>
                </li>

                <li>
                    <a href="historic_upload_payroll.php">
                        <i class="metismenu-icon pe-7s-timer"></i>
                        Historic upload Payroll
                    </a>
                </li>
                
                <li>
                    <a href="print_payroll.php">
                        <i class="metismenu-icon pe-7s-print"></i>
                        Print last payroll upload
                    </a>
                </li>


                <li>
                    <a href="upload_fast_check.php">
                        <i class="metismenu-icon pe-7s-upload"></i>
                        Create Fast Check
                    </a>
                </li>
                <li>
                    <a href="historic_upload_fast_check.php">
                        <i class="metismenu-icon pe-7s-timer"></i>
                        Historic upload Fast Check
                    </a>
                </li>
                <li>
                <a href="javascript:salir()" class="dropdown-item">
                <i class="metismenu-icon pe-7s-close"></i>
                exit</a>
                </li>
                

                <?php
                }else{?>
                <li class="app-sidebar__heading">Profile</li>
                <li>
                    <a href="perfil.php?id=<?php echo  $_SESSION['user_login_status']['id'] ?>">
                        <i class="metismenu-icon pe-7s-user"></i>
                        my profile
                    </a>
                </li>

                <li>
                    <a href="historic_pay_employee.php?id=<?php echo  $_SESSION['user_login_status']['id'] ?>">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Historic Payroll
                    </a>
                </li>
                <li>
                    <a href="certificate.php">
                        <i class="metismenu-icon pe-7s-file"></i>
                        certificates
                    </a>
                </li>

                <li>
                <a href="javascript:salir()" class="dropdown-item">
                <i class="metismenu-icon pe-7s-close"></i>
                exit</a>
                </li>
                <?php
                }
                ?>
                
            </ul>
        </div>
    </div>
</div>