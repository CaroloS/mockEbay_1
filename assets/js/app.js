SELECT c.categoryHierarchy1, i.itemCondition, i.imageURL, p.productName,d.endDate,d.auction, d.buyItNow, u.firstName,u.lastName, p.productDescritpion, i.saleID
FROM Category c, itemForSale i, Product p, SaleDescription d, Users u, Sale s, SellerDetails 
WHERE c.categoryID=p.categoryID AND i.productID=p.productID AND i.saleID= s.saleID AND s.saleID=d.saleID AND s.sellerID=e.sellerID AND e.userID=u.userID
ORDER BY d.endDate;