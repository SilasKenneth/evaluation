# Import the helper gateway class
from AfricasTalkingGateway import AfricasTalkingGateway, AfricasTalkingGatewayException

# Specify your login credentials
username = "silaskenn"
apikey   = "af5e6a10a42ca410712c6598bbb1f5ba8670d54ae2982e8ef0f939600e0ebe9c"

# Specify the numbers that you want to send to in a comma-separated list
# Please ensure you include the country code (+254 for Kenya)
to      = "+254789780502"

# And of course we want our recipients to know what we really do
message = "I feel so bad, so sick so hungry I even feel like dying now. Please if you dont mind kesho morning please sahizi nko wifi ata nmeshindwa kutembea kwenda kwa nyumba, I might sleep here sina nguvu ya kutembea"

# Create a new instance of our awesome gateway class
gateway = AfricasTalkingGateway(username, apikey)

#*************************************************************************************
#  NOTE: If connecting to the sandbox:
#
#  1. Use "sandbox" as the username
#  2. Use the apiKey generated from your sandbox application
#     https://account.africastalking.com/apps/sandbox/settings/key
#  3. Add the "sandbox" flag to the constructor
#
#  gateway = AfricasTalkingGateway(username, apiKey, "sandbox");
#**************************************************************************************

# Any gateway errors will be captured by our custom Exception class below, 
# so wrap the call in a try-catch block
try:
    # Thats it, hit send and we'll take care of the rest.
    
    results = gateway.sendMessage(to, message)
    
    for recipient in results:
        # status is either "Success" or "error message"
        print 'number=%s;status=%s;statusCode=%s;messageId=%s;cost=%s' % (recipient['number'],
                                                            recipient['status'],
                                                            recipient['statusCode'],
                                                            recipient['messageId'],
                                                            recipient['cost'])
except AfricasTalkingGatewayException, e:
    print 'Encountered an error while sending: %s' % str(e)
