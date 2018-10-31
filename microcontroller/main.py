import time
import machine
import dht
import urequests
import network

from machine import Pin
from dht import DHT11

url = "YOUR IP"

# Connect to WIFI
routercon = network.WLAN(network.STA_IF)
routercon.active()
routercon.active(True)
routercon.connect('leco_op', '88888888')
routercon.ifconfig()

#Set-up led
led = machine.Pin(5, machine.Pin.OUT)

# Set-up temperature sensor.
d = DHT11(Pin(4))
d.measure()

while True:
    led.on()
    temperature = d.temperature()
    response = urequests.post(url + "/new", json={'temperature': temperature, 'location': 'Sensor 2'})
    response.close()
    led.off()
    time.sleep(30)