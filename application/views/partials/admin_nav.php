<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar-content">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/dashboard"><?php echo $site_name; ?></a>
		</div>

		<div class="collapse navbar-collapse" id="mynavbar-content">

			<!-- Issue New Questionnaire -->
			<a href="/dashboard/issue" class="btn btn-success navbar-btn btn-sm"><span class="glyphicon glyphicon-file"></span> Issue New Questionnaire</a>

			<!-- Settings Menu -->
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/dashboard/account"><?php echo $user_name; ?></a></li>
				<li class="dropdown">
					<a href="/dashboard/account" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Settings <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/dashboard/account"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
						<li><a href="/dashboard/password"><span class="glyphicon glyphicon-edit"></span> Change Password</a></li>
						<li class="divider"></li>
						<li><a href="/dashboard/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>

	</div>
</div>