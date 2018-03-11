<?php
		class Date
			{
				public function getDate()
					{
						$timezone = new DateTimeZone("Asia/Kolkata");
					    $datetime = new DateTime();
					    $datetime->setTimezone($timezone);
					    return $datetime->format('Y-m-d H:i:s');
					}
			}

		class Connection
			{
				function __construct()
					{
						if(isset($_SERVER['SERVER_NAME']))
							{
								switch($_SERVER['SERVER_NAME'])
									{
										case 'www.practicaltest.com':
										$this->config = $this->dev;
										break;

										case 'regurtechnologysolutions.akshayshrivastav.me':
										$this->config = $this->prod;
										break;

										default:
										$this->config = $this->dev;
										break;
									}
							}
						else
							{
								$this->config = $this->dev;
							}
					}

					public $dev = array(
											'host' => 'localhost',
											'user' => 'root',
											'pass' => '',
											'db' => 'practicalTestRegurTechnologySolutions',
									     );

					public $prod = array(
											'host' => 'localhost',
											'user' => 'akshayshrivastav_regur',
											'pass' => 'Regur@.2018',
											'db' => 'akshayshrivastav_regurtechsol',
										);

				public function establish_connection()
					{
						$connection = new mysqli($this->config['host'], $this->config['user'], $this->config['pass'], $this->config['db']);

						if($connection == TRUE)
							{
								return $connection;
							}
						else
							{
								die("Could Not Establish Connection! ".$connection->error);
							}
					}
			}
?>