<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
	body {
		text-align: center;
		padding: 40px 0;
		background: #EBF0F5;
	}

	h1 {
		margin-top: 20px;
		color: #000;
		font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
		font-weight: 900;
		font-size: 40px;
		margin-bottom: 10px;
	}

	p {
		color: #404F5E;
		font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
		font-size: 20px;
		margin: 0;
	}

	i {
		color: #9ABC66;
		font-size: 100px;
		line-height: 200px;
		margin-left: -15px;
	}

	.card {
		background: white;
		padding: 60px;
		border-radius: 4px;
		box-shadow: 0 2px 3px #C8D0D8;
		display: inline-block;
		margin: 0 auto;
	}

	.rate {
		/* float: left; */
		height: 46px;
		padding: 0 10px;
        margin-bottom: 30px;
	}

	.rate:not(:checked)>input {
		position: absolute;
		top: -9999px;
	}

	.rate:not(:checked)>label {
		float: right;
		width: 1em;
		overflow: hidden;
		white-space: nowrap;
		cursor: pointer;
		font-size: 50px;
		color: #ccc;
	}

	.rate:not(:checked)>label:before {
		content: '★ ';
	}

	.rate>input:checked~label {
		color: #FFE952;
	}

	.rate:not(:checked)>label:hover,
	.rate:not(:checked)>label:hover~label {
		color: #FFE952;
	}

	.rate>input:checked+label:hover,
	.rate>input:checked+label:hover~label,
	.rate>input:checked~label:hover,
	.rate>input:checked~label:hover~label,
	.rate>label:hover~input:checked~label {
		color: #FFE952;
	}

	.button {
        background-color: #9ABC66;
        border: none;
        color: white;
        padding: 15px 50px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 25px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 12px;
	}
</style>

<body>
	<div class="card">
		<div style="border-radius:200px; height:190px; width:200px; background: #F8FAF5; margin:0 auto;">
			<i class="checkmark">✓</i>
		</div>
		<h1>الرجاء تقييم الجلسة</h1>

		<div class="rate">
			<input type="radio" id="star5" name="rate" value="5" />
			<label for="star5" title="text">5 stars</label>
			<input type="radio" id="star4" name="rate" value="4" />
			<label for="star4" title="text">4 stars</label>
			<input type="radio" id="star3" name="rate" value="3" />
			<label for="star3" title="text">3 stars</label>
			<input type="radio" id="star2" name="rate" value="2" />
			<label for="star2" title="text">2 stars</label>
			<input type="radio" id="star1" name="rate" value="1" />
			<label for="star1" title="text">1 star</label>
		</div>

        <button class="button">حفظ</button>
	</div>
</body>

</html>
