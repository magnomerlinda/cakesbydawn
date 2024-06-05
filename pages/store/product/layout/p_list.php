<style>
    ul {
        padding: 10px;
        margin: 0;
        list-style: none;
    }

    li {
        background-color: white;
        color: #AABEC0;
        padding: 20px 25px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 3px 3px 18px 2px rgba(0, 0, 0, 0.3);
    }

    @media (min-width: 769px) {
        ul {
            display: flex;
            justify-content: space-between;
        }
    }

    @media (max-width: 768px) {
        ul {
            display: block;
        }

     
    }
</style>
<ul>
    <?php
    if ($result->num_rows > 0) {
		
		echo "<ul >";
        while($row = $result->fetch_assoc()) {
           echo "<li>";
		echo "<img src='../admin/" . $row['Image'] . "' alt='Product Image' style='max-width: 130px; 
																					border-radius: 10px;
																					box-shadow: 5px 5px 8px 2px rgba(0, 0, 0, 0.3);
																					margin-left: 2%; margin-top: 10px; margin-bottom: 15px;
																					'><br>";
        echo "<strong>Name:</strong> " . $row['Name'] . "<br>";
        echo "<strong>Description:</strong> " . $row['Description'] . "<br>";
        echo "<strong>Price:</strong> ₱" . $row['Price'] . "<br>";
        echo "<strong>Category:</strong> " . $row['Category'] . "<br>";
        
        
        // Add to Cart button
        echo "<form method='post'>";
        echo "<input type='hidden' name='productId' value='" . $row['ProductID'] . "'>";
        echo "<input type='hidden' name='productName' value='" . $row['Name'] . "'>";
        echo "<input type='hidden' name='productPrice' value='" . $row['Price'] . "'>";
        echo "<input type='submit' name='addToCart' value='ADD TO &#x1F6D2; ' style='margin-top: 10px; width: 70px;
				  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
				  width: 100%;
				  background-color: #66D2D6;
				  color: white;
				  border: none;
				  padding: 10px 20px;
				  font-size: 16px;
				  border-radius: 5px;
				  cursor: pointer;
				  transition: background-color 0.3s ease;'> ";
        echo "</form>";
        
        echo "</li>";
        }
    } else {
        echo "<li>No products found in this category.</li>";
    }
    ?>
    </ul>