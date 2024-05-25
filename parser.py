import xml.dom.minidom
import re
import mysql.connector

db = mysql.connector.connect(user='root', password='123', host='localhost', db='test')
cursor = db.cursor()

for i in range(20):
    bstr = 'b' + str(i) + '.xhtml'
    estr = 'e' + str(i) + '.xhtml'

    print('\n\t' + bstr)
    bestBuy = xml.dom.minidom.parse(bstr)
    #name
    name = bestBuy.getElementsByTagName('h1')[0].childNodes[0].nodeValue
    #price
    nodes = bestBuy.getElementsByTagName('div')
    for n in nodes:
        if n.getAttribute('data-testid') == "customer-price":
            price = n.childNodes[0].childNodes[0].nodeValue
            price = price[1:]
    #description
    nodes = bestBuy.getElementsByTagName('div')
    desc = None
    for n in nodes:
        try:
            if n.getAttribute('class') == 'mb-400':
                desc = n.childNodes[0].childNodes[0].childNodes[3].childNodes[0].nodeValue
                desc = re.search(r'plainText\\":\\"[a-zA-Z0-9 ,’\'\.\-\(\)—%¹²³]*', desc)
                desc = desc.group()[14:]
                break
        except IndexError:
           pass 
    if not desc:
        for n in nodes:
            if n.getAttribute('class') == 'description-text clamp lv':
                desc = n.childNodes[0].childNodes[0].nodeValue
                break
    #image
    nodes = bestBuy.getElementsByTagName('img')
    for n in nodes:
        if n.getAttribute('class') == 'primary-image':
            imageLink = n.getAttribute('src')
    #rating
    nodes = bestBuy.getElementsByTagName('div')
    for n in nodes:
        if n.getAttribute('class') == 'c-ratings-reviews flex c-ratings-reviews-small align-items-center gap-50 ugc-ratings-reviews flex-wrap small-gaps text-center':
            rating = n.firstChild.firstChild.nodeValue[:-1]
    #now insert into database
    sql = "REPLACE INTO BestBuy (id, name, price, rating, image, description) VALUES (%s, %s, %s, %s, %s, %s)"
    val = (i, name, price, rating, imageLink, desc)
    cursor.execute(sql, val)

   

    print('\t' + estr)
    eBay = xml.dom.minidom.parse(estr)
    #name
    name = eBay.getElementsByTagName('h1')[0].childNodes[1].childNodes[0].nodeValue
    #price
    nodes = eBay.getElementsByTagName('div')
    for n in nodes:
        if n.getAttribute('class') == 'x-bin-price__content':
            price = n.childNodes[0].childNodes[0].childNodes[0].nodeValue
            price = re.search("[0-9]*\.[0-9]*", price).group()
    #description uh oh
    desc = None
    #image
    nodes = eBay.getElementsByTagName('img')
    for n in nodes:
        if n.getAttribute('fetchpriority') == 'high':
            imageLink = n.getAttribute('src')

    #rating
    nodes = eBay.getElementsByTagName('div')
    rating = None
    for n in nodes:
        if n.getAttribute('class') == 'star-rating':
            rating = n.getAttribute('aria-label')
            r = rating[0:3]
            n = re.search("on [0-9]*", rating).group()[3:]
            rating = 'User rating, ' + r + ' out of 5 stars with ' + n + ' reviews'
            break
    if not rating:
        nodes = eBay.getElementsByTagName('div');
        for n in nodes:
            if n.getAttribute('class') == 'd-stores-info-categories__container__info__section__item':
                rating = n.firstChild.firstChild.nodeValue
                rating = 'Seller has ' + rating + ' positive feedback from customers'
                break
    #sql
    sql = "REPLACE INTO eBay (id, name, price, rating, image, description) VALUES (%s, %s, %s, %s, %s, %s)"
    val = (i, name, price, rating, imageLink, desc)
    cursor.execute(sql, val)



db.commit()
