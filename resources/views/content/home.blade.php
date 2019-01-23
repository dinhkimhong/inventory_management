@guest
<div id="introduction" class="pt-3">
	<div style="border-bottom: 1px solid #cccccc;">
		<img class="rounded float-right" src="img/KimHong.jpg" alt="Kimhong" width="150" height="150">
		<h3>Welcome to my website</h3>
		<p>Thank you for visiting. I'm Kimhong.</p>
		<p>With passion in database and ideas are from my experience in ERP system, I have built this website to help small business in manage inventory, cost and profit effeciently. It's about goods movement from purchasing, goods receipt, creating orders, goods delivery, issuing invoice to customer. Additional, there is one function to create Bill of material, so you can know much raw materials you need to build a finished product.</p>
		<p>The project has 2 parts:</p>
		<ul style="list-style: none;">
			<li>Part 1: Inbound movement and Bill of material <a href="https://www.sproutberry.com">(www.sproutberry.com)</a></li>
			<li>Part 2: Outbound movement <a href="http://www.kimhong.tech">(www.kimhong.tech)</a></li>
		</ul>

<!-- 		<p>The reason I created this website is that since I started learning programming languages and know that a web can work like a system, I'm really interested in it and I do like coding. I want to create something new.</p> -->

	</div>
	<div class="pt-3" style="border-bottom: 1px solid #cccccc;">
		<h3>Programming languages used</h3>
<!-- 		<p>It works similar to ERP system but it is more simple as this website is used for 1 company,</p>
		<div>
			<p><u>Programming language use:</u></p> -->
			<ul style="list-style: none;">
				<li>HTML</li>
				<li>CSS, Bootstrap</li>
				<li>Jquery</li>
				<li>MySQL</li>
				<li>PHP, Laravel framework</li>
			</ul>
		<!-- </div> -->
	</div>
	<div class="pt-3" style="border-bottom: 1px solid #cccccc;">
		<h3>About me</h3>
			<ul style="list-style: none;">
				<li>I enjoy thinking about better ways to accomplish projects</li>
				<li>I like to set timelines and meet deadlines for every tasks</li>
				<li>I'm a hard worker and fast learner</li>
				<li>I enjoy planning and organizing time and resources effectively</li>
				<li>I'm easily adapt to team environment and high pressure</li>
				<li>My quote is:"Success is no accident. It is hard work, perseverance, learning, studying, sacrifice and most of all, love of what you are doing or learning to do" - Pele</li>
			</ul>
		<!-- </div> -->
	</div>
	<div class="pt-3" style="border-bottom: 1px solid #cccccc;">
		<h3>Education / Training Background</h3>
		<p>Bachelor of Economics, major in Business Administration, University of Economics Ho Chi Minh City, 2005-2009.</p>
		<p>Computer skill: Microsoft Office, ERP system: SAP, Dynamics AX, CRM, SAP C4C</p>
	</div>

	<div class="pt-3" style="border-bottom: 1px solid #cccccc;">
		<h3>Employment History</h3>
		<div class="table-responsive-sm">
			<table class="table table-bordered">
				<thead class="thead-light">
					<tr>
						<th scope="col">Company</th>
						<th scope="col">Time</th>
						<th scope="col">Position</th>
					</tr>
				</thead>
				<tbody class="table-hover">
					<tr>
						<td>Home Depot Canada</td>
						<td>May 2018 - Dec 2018</td>
						<td>Special Services</td>
					</tr>

					<tr>
						<td>Kitchen Quickies Organic Grocery Store</td>
						<td>Mar 2018 -  July 2018</td>
						<td>Book Keeper (Temporary Contract)</td>
					</tr>
					<tr>
						<td>Azelis Vietnam Co., Ltd</td>
						<td>Nov 2016 – Mar 2017</td>
						<td>Logistics Cutomer Service</td>
					</tr>
					<tr>
						<td>Jebsen & Jessen Group</td>
						<td>June 2011 – Aug 2016</td>
						<td>Logistics Cutomer Service</td>
					</tr>
					<tr>
						<td>Grohe Vietnam Co., Ltd</td>
						<td>Dec 2010 – May 2011 </td>
						<td>Executive Assistant</td>
					</tr>
					<tr>
						<td>Robert Bosch Vietnam Co., Ltd</td>
						<td>May 2009 – Nov 2010</td>
						<td>Sales Customer Service cum Executive Assistant</td>
					</tr>
				</tbody>			
			</table>
		</div>
	</div>
</div>



@elseif(Auth::user()->authorizeRoles('AD'))
<header>
	<h3>Manage User</h3>
</header>
<form action="{{route('updateUsers')}}" method="POST">
	@csrf
	<table class="table table-bordered form-group table-responsive-md" id="tblOne">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">User ID</th>
                <th scope="col">User name</th>
                <th scope="col">Email address</th>
                <th scope="col">Role</th>
                <th scope="col">Active</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($users as $key=>$user)
            <tr>
                <td>{{ ++$key }}</td>
                <td><input type="text" name="id[]" value="{{ $user->id}}" class="form-control"></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <!-- <td>{{ $user->roles()->pluck('description')->first()}}</td> -->
                <td>
			        <select name="role[]" class="custom-select">
			        	@foreach($roles as $role)
			            <option value="{{$role->id}}" @if( $user->roles()->pluck('description')->first() == $role->description) selected ="true" @endif>{{ $role->description }}</option>
			            @endforeach
			        </select>

                </td>
                <td id="switch"> 
                	@if ($user->active == 1)
                	<label class="switch">
			              <input type="checkbox" checked class="active">
			              <span class="slider round"></span>
			        </label>
			        @else
                	<label class="switch">
			              <input type="checkbox" class="active">
			              <span class="slider round"></span>
			        </label>

			        @endif

    			</td>      
            </tr>
            @endforeach

        </tbody>
    </table> 
    <button class="btn btn-save">Update</button>
</form>
@else
<div id="accordion" role="tablist" class="p-3">
	<h3>Project</h3>
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h4 class="mb-0" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">
        Overview
      </h4>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
      	<p>Company name: Sprout Berry has 1 warehouse</p>
        <p>Part 1: Inbound movement and Bill of material</p>
        <p>***I use this site for practice what I learned so I use different style of codes and I focus on function instead of view</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h4 class="mb-0 collapsed" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">How it works?</h4>
    </div>
    <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <p>Let's go through procedure of creating 1 project for production: <br>
          1. Need master data of material<br>
          2. Need master data of vendor to create Purchase Order then you can print Purchase Order and send to supplier (you can print when you review purchase order)<br>
          3. When goods arrived, you need to do Inbound (you can do many inbounds as supplier doesn't delivery goods at once but the quantity does not exceed quantity in Purchase Order)<br>
          * After doing inbound, moving price (COGS) in material data will be updated<br>
          4. Create BOM include: Raw Material, Semifinished Goods, Finished Goods<br>
          5. Create project (how many finished goods you want to produce and it will show all raw materials you need)<br><br>
        </p>

      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h4 class="mb-0 collapsed" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="true" aria-controls="collapseThree">
        What is in Part 2?  <a href="http://www.kimhong.tech">click here</a> 
      </h4>
    </div>
    <div id="collapseThree" class="collapse show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        <p>Create sales order, pick products from warehouse for delivery (goods delivery) and issue billing (invoice) <br>
          1. Need master data of customer<br>
          2. Create sales order in system (update/delete if needed)<br>
          3. Warehouse person will pick products and post goods delivery<br>
          4. Post invoice then print invoice to customer<br>
      </p>
      </div>
    </div>
  </div>
</div>
@endguest
@section('script')
<script type="text/javascript">
	checkedID();

	function checkedID(){
		$('#tblOne > tbody  > tr').each(function(){
			if($('.active').attr('checked') == false){
			var addRow = "<td><input type='text' name='active[]' value='0' class='form-control'></td>";
			$(this).append(addRow);
			}else{
			var addRow = "<td><input type='text' name='active[]' value='1' class='form-control'></td>";
			$(this).append(addRow);
			}
		})
	};
</script>




@endsection