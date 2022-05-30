<?php

//issue_book_details.php

include 'database_connection.php';

include 'function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$query = "
	SELECT * FROM lms_issue_book 
	INNER JOIN lms_book 
	ON lms_book.book_isbn_number = lms_issue_book.book_id 
	WHERE lms_issue_book.user_id = '".$_SESSION['user_id']."' 
	ORDER BY lms_issue_book.issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
     
</head>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Issue Book Detail</h1>
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Issue Book Detail
				</div>
				<div class="col col-md-6" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Book ISBN No.</th>
						<th>Book Name</th>
						<th>Issue Date</th>
						<th>Return Date</th>
						<th>Fines</th>
						<th>Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Book ISBN No.</th>
						<th>Book Name</th>
						<th>Issue Date</th>
						<th>Return Date</th>
						<th>Fines</th>
						<th>Status</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 
				if($statement->rowCount() > 0)
				{
					foreach($statement->fetchAll() as $row)
					{
						$status = $row["book_issue_status"];
						if($status == 'Issue')
						{
							$status = '<span class="badge bg-warning">Issue</span>';
						}

						if($status == 'Not Return')
						{
							$status = '<span class="badge bg-danger">Not Return</span>';
						}

						if($status == 'Return')
						{
							$status = '<span class="badge bg-primary">Return</span>';
						}

						echo '
						<tr>
							<td>'.$row["book_isbn_number"].'</td>
							<td>'.$row["book_name"].'</td>
							<td>'.$row["issue_date_time"].'</td>
							<td>'.$row["return_date_time"].'</td>
							<td>'.get_currency_symbol($connect).$row["book_fines"].'</td>
							<td>'.$status.'</td>
						</tr>
						';
					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<?php 

include 'footer.php';

?>
