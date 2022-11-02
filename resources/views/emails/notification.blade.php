<div style="text-align:center">
    <h1>{{ucfirst($zone->name)}}</h1>
    <h2>{{ucfirst($type)}} Problem</h2>
    @if(!empty($temperature) || !empty($humidity) )
        <h2>Sensor Data</h2>
    @endif
    @if(!empty($temperature))
        <h3>Temperatur: {{$temperature}} </h3>
    @endif
    @if(!empty($humidity))
        <h3>Luftfugtighed: {{$humidity}} </h3>
    @endif
    @if(!empty($my_message))
        <h3>Besked: {{$my_message}} </h3>
    @endif
</div>
