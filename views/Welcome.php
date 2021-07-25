<?php

namespace PHPMaker2021\test;

// Page object
$Welcome = &$Page;
?>
<div class="panel panel-default">
	<!-- <div class="panel-heading">Transit Media - Vendor Portal</div> -->


	<div class="panel-body">

			<div class="callout callout-warning">
                  <h5 style=" text-transform: capitalize; ">Hello <?php echo Profile()->name; /*CurrentUserName();*/ ?></h5>

                  <p>Choose between Primero TSL and Lagos Bus Reform Buses below?</p>
                </div>

	</div>


</div>

<!-- 
<div class="panel panel-default">
	<div class="panel-heading">Quick Links</div>
	<div class="panel-body">
			<a class="btn btn-app" href="exterior_campaignsadd.php?showdetail=">
				<i class="fa  fa-plus-square"></i> Order Exterior
			</a>

			<a class="btn btn-app">
				<i class="fa  fa-plus-square-o"></i> Order Hangers & Seat Cover
			</a>
			<a class="btn btn-app" href="buseslist.php?cmd=resetall">
				<i class="fa fa-bus"></i> View Buses
			</a>
			<a class="btn btn-app" href="exterior_campaignslist.php?cmd=resetall">
				<i class="fa fa-bullhorn"></i> View Campaigns
			</a>
			<a class="btn btn-app" href="exterior_reportslist.php?cmd=resetall">
				<i class="fa fa-line-chart"></i> View Reports
			</a>
			<a class="btn btn-app" href="faq.php">
				<i class="fa fa-question"></i> F.A.Q / Help
			</a>
	</div>
</div>

 -->



<div class="panel panel-default">
	<h2>Platforms</h2>


<section class="maincontent">



<div class="welcome-row">
  <div class="welcome-col-5-empty"></div>
  <div class="welcome-col-5">
	  <div class="small-box bg-light">
			<div class="inner">
			  <h3>PRIMERO</h3>

			  <p>Primero TSL</br>Buses</p>
			  <div class="platform-image">
				  <img src="images/primero_logo.png" />
			  </div>
			</div>
			<div class="icon">
			  <i class="ion ion-bus"></i>
			</div>
			<!-- <button type="button" class="btn btn-block bg-gradient-primary">Create Campaign</button> -->
			<a class="btn btn-lg btn-block bg-gradient-warning" href="maincampaignsadd?showdetail=&showmaster=y_platforms&fk_id=1">
				<!-- <i class="fa fa-bullhorn"></i> --> Create Campaign
			</a>
			<!-- <a href="exterior_campaignslist.php?cmd=resetall" class="small-box-footer">
			  More info <i class="fa fa-arrow-circle-right"></i>
			</a> -->
		  </div>
  </div>
  <div class="welcome-col-5-empty"></div>
  <div class="welcome-col-5">
	  <div class="small-box bg-light">
			<div class="inner">
			  <h3>LAMATA</h3>

			  <p>Lagos Bus Reform</br>Buses</p>
			  <div class="platform-image">
				  <img src="images/lamata_logo.jpg" />
			  </div>
			</div>
			<div class="icon">
			  <i class="ion ion-person-add"></i>
			</div>
			<a class="btn btn-lg btn-block bg-gradient-warning" href="maincampaignsadd?showdetail=&showmaster=y_platforms&fk_id=2">
				<!-- <i class="fa fa-bullhorn"></i>--> Create Campaign 
			</a>
			<!-- <a href="buseslist.php?cmd=resetall" class="small-box-footer">
			  More info <i class="fa fa-arrow-circle-right"></i>
			</a> -->
		  </div>
  </div>
  <div class="welcome-col-5-empty"></div>
</div>




<?php
/*

	  <!-- Small boxes (Stat box) -->
	  <div class="row">
		<div class="col-lg-3 col-xs-6">
		 
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-light">
			<div class="inner">
			  <h3>PRIMERO</h3>

			  <p>Primero TSL</br>Buses</p>
			  <div class="platform-image">
				  <img src="images/primero_logo.png" />
			  </div>
			</div>
			<div class="icon">
			  <i class="ion ion-bus"></i>
			</div>
			<!-- <button type="button" class="btn btn-block bg-gradient-primary">Create Campaign</button> -->
			<a class="btn btn-lg btn-block bg-gradient-warning" href="maincampaignsadd?showdetail=&showmaster=y_platforms&fk_id=1">
				<!-- <i class="fa fa-bullhorn"></i> --> Create Campaign
			</a>
			<!-- <a href="exterior_campaignslist.php?cmd=resetall" class="small-box-footer">
			  More info <i class="fa fa-arrow-circle-right"></i>
			</a> -->
		  </div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-light">
			<div class="inner">
			  <h3>LAMATA</h3>

			  <p>Lagos Bus Reform</br>Buses</p>
			  <div class="platform-image">
				  <img src="images/lamata_logo.jpg" />
			  </div>
			</div>
			<div class="icon">
			  <i class="ion ion-person-add"></i>
			</div>
			<a class="btn btn-lg btn-block bg-gradient-warning" href="maincampaignsadd?showdetail=&showmaster=y_platforms&fk_id=2">
				<!-- <i class="fa fa-bullhorn"></i>--> Create Campaign 
			</a>
			<!-- <a href="buseslist.php?cmd=resetall" class="small-box-footer">
			  More info <i class="fa fa-arrow-circle-right"></i>
			</a> -->
		  </div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		
		</div>
		<!-- ./col -->
	  </div>
	  <!-- /.row -->
<?php */ ?>
		
</section>	
</div>


<?php /* ?>

<div class="panel panel-default">
<h2>Prices</h2>


<section class="maincontent">

<div class="card">
	<div class="card-header">
		<h3 class="card-title">BRT TV Prices</h3>
		<div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
	</div>
	<div class="card-body p-0">
<?php
	$sql = "select 
platform as \"Platform\", 
--inventory as \"Inventory\",
--print_stage as \"Print Stage\",
bus_size as \"Bus Size\",
to_char(price, 'N999,999,999,990'::text) as \"Price\",
details as \"Details\"

from 
view_pricing_all
where inventory_id = 3
order by platform_id desc, inventory_id, bus_size, price desc";
	//Write(ExecuteHtml($sql, ["fieldcaption" => false, "tablename" => ["view_pricing_all"]]));
?>
	</div>
</div>



<div class="row">

<div class="col-lg-6">


<div class="card">
	<div class="card-header">
		<h3 class="card-title">Exterior Print Prices</h3>
		<div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
	</div>
	<div class="card-body p-0">
<?php
	$sql = "select 
platform as \"Platform\", 
--inventory as \"Inventory\",
print_stage as \"Print Stage\",
bus_size as \"Bus Size\",
to_char(price, 'N999,999,999,990'::text) as \"Price\",
details as \"Details\"

from 
view_pricing_all
where inventory_id = 1
order by platform_id desc, inventory_id, bus_size";
	//Write(ExecuteHtml($sql, ["fieldcaption" => false, "tablename" => ["view_pricing_all"]]));
?>
	</div>
</div>


</div>

<div class="col-lg-6">

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Interior Print Prices</h3>
		<div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
	</div>
	<div class="card-body p-0">
<?php
	$sql = "select 
platform as \"Platform\", 
--inventory as \"Inventory\",
print_stage as \"Print Stage\",
bus_size as \"Bus Size\",
to_char(price, 'N999,999,999,990'::text) as \"Price\",
details as \"Details\"

from 
view_pricing_all
where inventory_id = 2
order by platform_id desc, inventory_id, bus_size";
//	Write(ExecuteHtml($sql, ["fieldcaption" => false, "tablename" => ["view_pricing_all"]]));
?>
	</div>
</div>


</div>


</div>


</section>
</div>


<?php */ ?>






















<?php

#$Email = new \PHPMailer\PHPMailer\PHPMailer();
#$Email->isHTML(true);
#print_r($Email);
?>



<?= GetDebugMessage() ?>
