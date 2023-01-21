    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a href="/"><i class="mbri-desktop "></i><span class="menu-title"
                            data-i18n="Dashboard">Dashboard</span></a>

                </li>

                @if (doPermitted('//stores'))
                    <li class=" nav-item"><a href="/stores"><i
                                class="la la-home"></i><span class="menu-title"
                                data-i18n="Apps">Stores</span></a>

                    </li>
                @endif

                @if (doPermitted('//bikes'))
                <li class=" nav-item"><a href="/bikes"><i
                            class="la la-bicycle"></i><span class="menu-title"
                            data-i18n="Apps">Bicycles</span></a>

                </li>
            @endif

                @if (doPermitted('//sale-report') || doPermitted('//feedback-report'))
                    <li class=" nav-item"><a href="#"><i class="
                        la la-book"></i><span class="menu-title"
                                data-i18n="Pages">Reports</span></a>
                        <ul class="menu-content">
                            @if (doPermitted('//sale-report'))
                                <li><a class="menu-item" href="/sale-report"><i
                                            class="la la-bar-chart"></i><span>Sale Report</span></a>
                                </li>
                            @endif
                            @if (doPermitted('//feedback-report'))
                                <li><a class="menu-item" href="/feedback-report"><i
                                            class="la la-bookmark-o"></i><span>Feedback Report</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (doPermitted('//users'))
                    <li class=" nav-item"><a href="#"><i class="mbri-setting3"></i><span class="menu-title"
                                data-i18n="Pages">System</span></a>
                        <ul class="menu-content">
                            @if (doPermitted('//users'))
                                <li><a class="menu-item" href="/users"><i
                                            class="la la-user-plus"></i><span>Users</span></a>
                                </li>
                            @endif
                            @if (doPermitted('//users'))
                                <li><a class="menu-item" href="/usertypes"><i
                                            class="la la-key"></i><span>Permission Levels</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>
