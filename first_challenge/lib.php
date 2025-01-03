<?php
class Products
{

    private $xml_file_path = '';

    public function __construct($xml_file_path = '')
    {
        $this->xml_file_path = $xml_file_path;
    }

    /**
     * This function prints an HTML table with all the products as read from the xml file
     * @return void 
     */
    public function print_html_table_with_all_products()
    {
        //TODO 1:Θα πρέπει να συμπληρώσουμε την συνάρτηση ώστε να κάνει print το HTML table με τα προϊόντα του xml
        $xmldata = simplexml_load_file($this->xml_file_path) or die("Failed to load");
        $xml_data = $xmldata->children();

        //Build the table with the labels
        echo "
            <table border='1'>
                <tr>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>CATEGORY</th>
                    <th>MANUFACTURER</th>
                    <th>BARCODE</th>
                    <th>WEIGHT</th>
                    <th>INSTOCK</th>
                    <th>AVAILABILITY</th>
                </tr>
        ";

        foreach ($xml_data->PRODUCTS->PRODUCT as $key => $prod) {
            
            $this->print_html_of_one_product_line($prod);
        
        }

        //Closing the table
        echo "</table>";
        
    }

    /**
     * This function prints an HTML tr for a given product
     * @param mixed $prod It is the product object as retrieved from the xml file
     * @return void 
     */
    private function print_html_of_one_product_line($prod){
        //TODO 2: Θα πρέπει να συμπληρώσουμε τη συνάρτηση ώστε να κάνει print τα tr με τα στοιχεία του ενός προϊόντος
        //var_dump($prod);

        //Build the line with the one product
        echo "<tr>";
        echo "<td>" . $prod->NAME . "</td>";
        echo "<td>" . $prod->PRICE . "</td>";
        echo "<td>" . $prod->QUANTITY . "</td>";
        echo "<td>" . $prod->CATEGORY . "</td>";
        echo "<td>" . $prod->MANUFACTURER . "</td>";
        echo "<td>" . $prod->BARCODE . "</td>";
        echo "<td>" . $prod->WEIGHT . "</td>";
        echo "<td>" . $prod->INSTOCK . "</td>";
        echo "<td>" . $prod->AVAILABILITY . "</td>";
        echo "</tr>";
    }

    public function add_product($name, $price, $quantity, $category, $manufacturer, $barcode, $weight, $instock, $availability)
    {

        //Adding an id in category as to other in XML depending on Category. Here is an example object of id's.
        $categoryMapping = [
            "BOARDS->Complete Skateboards" => "113000102",
            "BOARDS->Decks" => "113000103",
            "SPORTS->Basketball" => "123000101",
        ];

        //Find the file for XML
        $xmldata = simplexml_load_file($this->xml_file_path) or die("Failed to load");

        //Add the products in XML file inside PRODUCTS->PRODUCT
        $newProduct = $xmldata->PRODUCTS->addChild('PRODUCT');

        //CData for Name
        $nameChild = $newProduct->addChild('NAME');
        $domName = dom_import_simplexml($nameChild);
        $owner = $domName->ownerDocument;
        $domName->appendChild($owner->createCDATASection($name));

        //Other Fields
        $newProduct->addChild('PRICE', htmlspecialchars($price));
        $newProduct->addChild('QUANTITY', htmlspecialchars($quantity));
        
        //Adding the Category with the proper ID from categoryMapping, if its not exist, adding a 0 id.
        $categoryChild = $newProduct->addChild('CATEGORY', htmlspecialchars($category));
        $categoryId = $categoryMapping[$category] ?? "000000000";
        $categoryChild->addAttribute('id', $categoryId);

        //Other Fields
        $newProduct->addChild('MANUFACTURER', htmlspecialchars($manufacturer));

        //CData for Barcode 
        $barcodeChild = $newProduct->addChild('BARCODE');
        $domBarcode = dom_import_simplexml($barcodeChild);
        $owner = $domBarcode->ownerDocument;
        $domBarcode->appendChild($owner->createCDATASection($barcode));

        //CData for Weight
        $weightChild = $newProduct->addChild('WEIGHT');
        $domWeight = dom_import_simplexml($weightChild);
        $owner = $domWeight->ownerDocument;
        $domWeight->appendChild($owner->createCDATASection($weight));

        //Other Fields
        $newProduct->addChild('INSTOCK', htmlspecialchars($instock));
        $newProduct->addChild('AVAILABILITY', htmlspecialchars($availability));

        //Passes the Data 
        $xmldata->asXML($this->xml_file_path);

        echo "Product Added!";
    }
}
