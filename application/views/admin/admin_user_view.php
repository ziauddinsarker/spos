

<section class="content">
	<div class="row">
		<div class="col-md-12 col-sm-16 col-xs-18">

			<div>
				<h1 class="page-header">Invoice</h1>
			</div>
			<?php

			foreach ($users as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			?>


	</div>
	</div>
</section>
