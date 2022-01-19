from django.shortcuts import render
from django.http import FileResponse, Http404, HttpResponse
from PyPDF2 import PdfFileReader
import PyPDF2


def index(request):
    # creating a pdf file object
    pdfFileObj = open(r'C:\Users\Abzedizo\Documents\translate\translator\static\enf20220118a1.pdf', 'rb')
    
    # creating a pdf reader object
    pdfReader = PyPDF2.PdfFileReader(pdfFileObj)
    
    # printing number of pages in pdf file
    print(pdfReader.numPages)
    
    # creating a page object
    pageObj = pdfReader.getPage(0)
    test = pageObj.extractText()
    
    # extracting text from page
    print(pageObj.extractText())
    
    # closing the pdf file object
    # pdfFileObj.close()
    return render(request, 'index.html', {'pdf': test})
