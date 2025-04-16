<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
	include_once(G5_THEME_MOBILE_PATH . '/index.php');
	return;
}

include_once(G5_THEME_PATH . '/head.php');

//dashboard 전까지 redirect
header("Location:" . G5_BIZ_URL . "/landing/db_list.php");
?>



<link rel="stylesheet" href="<?php echo G5_THEME_URL; ?>/plugins/fullcalendar/main.css">
<script src="<?php echo G5_THEME_URL; ?>/plugins/fullcalendar/main.js"></script>




<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Dashboard v1</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div id="calendar"></div>

		</div>
	</div>
</section>
<!-- <section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="small-box bg-info">
					<div class="inner">
						<h3>150</h3>

						<p>New Orders</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-success">
					<div class="inner">
						<h3>53<sup style="font-size: 20px">%</sup></h3>

						<p>Bounce Rate</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-warning">
					<div class="inner">
						<h3>44</h3>

						<p>User Registrations</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-danger">
					<div class="inner">
						<h3>65</h3>

						<p>Unique Visitors</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div class="row">
			<section class="col-lg-7 connectedSortable">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">
							<i class="fas fa-chart-pie mr-1"></i>
							Sales
						</h3>
						<div class="card-tools">
							<ul class="nav nav-pills ml-auto">
								<li class="nav-item">
									<a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-body">
						<div class="tab-content p-0">
							<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
								<canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
							</div>
							<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
								<canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
							</div>
						</div>
					</div>
				</div>

				<div class="card direct-chat direct-chat-primary">
					<div class="card-header">
						<h3 class="card-title">Direct Chat</h3>

						<div class="card-tools">
							<span title="3 New Messages" class="badge badge-primary">3</span>
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
								<i class="fas fa-comments"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="direct-chat-messages">
							<div class="direct-chat-msg">
								<div class="direct-chat-infos clearfix">
									<span class="direct-chat-name float-left">Alexander Pierce</span>
									<span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
								</div>
								<img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
								<div class="direct-chat-text">
									Is this template really for free? That's unbelievable!
								</div>
							</div>

							<div class="direct-chat-msg right">
								<div class="direct-chat-infos clearfix">
									<span class="direct-chat-name float-right">Sarah Bullock</span>
									<span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
								</div>
								<img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
								<div class="direct-chat-text">
									You better believe it!
								</div>
							</div>

							<div class="direct-chat-msg">
								<div class="direct-chat-infos clearfix">
									<span class="direct-chat-name float-left">Alexander Pierce</span>
									<span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
								</div>
								<img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
								<div class="direct-chat-text">
									Working with AdminLTE on a great new app! Wanna join?
								</div>
							</div>

							<div class="direct-chat-msg right">
								<div class="direct-chat-infos clearfix">
									<span class="direct-chat-name float-right">Sarah Bullock</span>
									<span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
								</div>
								<img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
								<div class="direct-chat-text">
									I would love to.
								</div>
							</div>

						</div>

						<div class="direct-chat-contacts">
							<ul class="contacts-list">
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												Count Dracula
												<small class="contacts-list-date float-right">2/28/2015</small>
											</span>
											<span class="contacts-list-msg">How have you been? I was...</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user7-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												Sarah Doe
												<small class="contacts-list-date float-right">2/23/2015</small>
											</span>
											<span class="contacts-list-msg">I will be waiting for...</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user3-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												Nadia Jolie
												<small class="contacts-list-date float-right">2/20/2015</small>
											</span>
											<span class="contacts-list-msg">I'll call you back at...</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user5-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												Nora S. Vans
												<small class="contacts-list-date float-right">2/10/2015</small>
											</span>
											<span class="contacts-list-msg">Where is your new...</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user6-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												John K.
												<small class="contacts-list-date float-right">1/27/2015</small>
											</span>
											<span class="contacts-list-msg">Can I take a look at...</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<img class="contacts-list-img" src="dist/img/user8-128x128.jpg" alt="User Avatar">

										<div class="contacts-list-info">
											<span class="contacts-list-name">
												Kenneth M.
												<small class="contacts-list-date float-right">1/4/2015</small>
											</span>
											<span class="contacts-list-msg">Never mind I found...</span>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-footer">
						<form action="#" method="post">
							<div class="input-group">
								<input type="text" name="message" placeholder="Type Message ..." class="form-control">
								<span class="input-group-append">
									<button type="button" class="btn btn-primary">Send</button>
								</span>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h3 class="card-title">
							<i class="ion ion-clipboard mr-1"></i>
							To Do List
						</h3>

						<div class="card-tools">
							<ul class="pagination pagination-sm">
								<li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
								<li class="page-item"><a href="#" class="page-link">1</a></li>
								<li class="page-item"><a href="#" class="page-link">2</a></li>
								<li class="page-item"><a href="#" class="page-link">3</a></li>
								<li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
							</ul>
						</div>
					</div>
					<div class="card-body">
						<ul class="todo-list" data-widget="todo-list">
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo1" id="todoCheck1">
									<label for="todoCheck1"></label>
								</div>
								<span class="text">Design a nice theme</span>
								<small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
									<label for="todoCheck2"></label>
								</div>
								<span class="text">Make the theme responsive</span>
								<small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo3" id="todoCheck3">
									<label for="todoCheck3"></label>
								</div>
								<span class="text">Let theme shine like a star</span>
								<small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo4" id="todoCheck4">
									<label for="todoCheck4"></label>
								</div>
								<span class="text">Let theme shine like a star</span>
								<small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo5" id="todoCheck5">
									<label for="todoCheck5"></label>
								</div>
								<span class="text">Check your messages and notifications</span>
								<small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
							<li>
								<span class="handle">
									<i class="fas fa-ellipsis-v"></i>
									<i class="fas fa-ellipsis-v"></i>
								</span>
								<div class="icheck-primary d-inline ml-2">
									<input type="checkbox" value="" name="todo6" id="todoCheck6">
									<label for="todoCheck6"></label>
								</div>
								<span class="text">Let theme shine like a star</span>
								<small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
								<div class="tools">
									<i class="fas fa-edit"></i>
									<i class="fas fa-trash-o"></i>
								</div>
							</li>
						</ul>
					</div>
					<div class="card-footer clearfix">
						<button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
					</div>
				</div>
			</section>
			<section class="col-lg-5 connectedSortable">

				<div class="card bg-gradient-primary">
					<div class="card-header border-0">
						<h3 class="card-title">
							<i class="fas fa-map-marker-alt mr-1"></i>
							Visitors
						</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
								<i class="far fa-calendar-alt"></i>
							</button>
							<button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div id="world-map" style="height: 250px; width: 100%;"></div>
					</div>
					<div class="card-footer bg-transparent">
						<div class="row">
							<div class="col-4 text-center">
								<div id="sparkline-1"></div>
								<div class="text-white">Visitors</div>
							</div>
							<div class="col-4 text-center">
								<div id="sparkline-2"></div>
								<div class="text-white">Online</div>
							</div>
							<div class="col-4 text-center">
								<div id="sparkline-3"></div>
								<div class="text-white">Sales</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card bg-gradient-info">
					<div class="card-header border-0">
						<h3 class="card-title">
							<i class="fas fa-th mr-1"></i>
							Sales Graph
						</h3>

						<div class="card-tools">
							<button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
					<div class="card-footer bg-transparent">
						<div class="row">
							<div class="col-4 text-center">
								<input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">

								<div class="text-white">Mail-Orders</div>
							</div>
							<div class="col-4 text-center">
								<input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">

								<div class="text-white">Online</div>
							</div>
							<div class="col-4 text-center">
								<input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">

								<div class="text-white">In-Store</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card bg-gradient-success">
					<div class="card-header border-0">

						<h3 class="card-title">
							<i class="far fa-calendar-alt"></i>
							Calendar
						</h3>
						<div class="card-tools">
							<div class="btn-group">
								<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
									<i class="fas fa-bars"></i>
								</button>
								<div class="dropdown-menu" role="menu">
									<a href="#" class="dropdown-item">Add new event</a>
									<a href="#" class="dropdown-item">Clear events</a>
									<div class="dropdown-divider"></div>
									<a href="#" class="dropdown-item">View calendar</a>
								</div>
							</div>
							<button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body pt-0">
						<div id="calendar" style="width: 100%"></div>
					</div>
				</div>
			</section>
		</div>
</section> -->





<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954', //red
          allDay         : true
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'https://www.google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
  })
</script>


<?php
include_once(G5_THEME_PATH . '/tail.php');
?>