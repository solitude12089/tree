<div class="navbar-default sidebar {{ isset($menu_open)&&$menu_open ? "" : "off" }}" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			
		

				<li>
					<a href="{{ url ('/account/index') }}">
						<i class="fa fa-cogs fa-fw"></i>帳號管理
					</a>
				

				</li>
				<li>
					<a href="{{ url ('/item/index') }}">
						<i class="fa fa-cogs fa-fw"></i>物件管理
					</a>
				

				</li>

			


		</ul>
	</div>
</div>
