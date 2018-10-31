import time
import machine
import dht
import urequests
import connectWifi

from machine import Pin
from dht import DHT11

# Connect to WIFI
connectWifi.connect()

url = "YOUR URL"

#Set-up led
led = machine.Pin(5, machine.Pin.OUT)

# Set-up temperature sensor.
d = DHT11(Pin(4))
d.measure()

#Proccess transmission.
while True:
    led.on()
    temperature = d.temperature()
    response = urequests.post(url, json={'temperature': temperature, 'location': 'Sensor 2'})
    response.close()
    led.off()
    time.sleep(30)