<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CESION DE CREDITOS Y MANDATO ESPECIAL IRREVOCABLE</title>
</head>
<body style="font-family: Arial Narrow, Arial, sans-serif; font-size: 11px; font-style: normal;">
    <div style="text-align: center;"> 
        <p style="">   CESION DE CREDITOS Y MANDATO ESPECIAL IRREVOCABLE </p>
            <p style="">  -A-</p>
                <p style="">   COMEXTECH SpA</p>
        </div>

    <div style="text-align: justify;">


<p>

 EN SANTIAGO DE CHILE,  <b>{{ date('d',strtotime($application->updated_at))}}</b> de <b>{{ date('m',strtotime($application->updated_at))}} </b> del año <b>{{ date('Y',strtotime($application->updated_at))}}</b>, entre:  <b>{{$application->user->company->name}}</b>, rol único tributario N° <b>{{$application->user->company->rut}}</b>,  representada según consta en la escritura pública de fecha <b>{{ isset($legal_info->writing_date) ? date('d-m-y',strtotime($legal_info->writing_date)) :date('d-m-y') }}</b>, outorgada en la Notaria de Santiago, de don <b>{{isset($legal_info->notary) ? $legal_info->notary : '__'}}</b>, repertorio N°<b>{{ isset($legal_info->repertoire_number) ? $legal_info->repertoire_number : '__'}}</b>,  por don(ña) __________________, Rut.N°_____, todos domiciliados en calle ________, de la comuna de ________, ciudad de Santiago, Región Metropolitana , en adelante “EL CLIENTE” o “EL CEDENTE” o “EL MANDANTE”, por una parte; y por la otra, la sociedad COMEXTECH SpA, del giro de empresas de asesoría y consultoría en inversión financiera sociedades de apoyo al giro, rol único tributario N° 76.722.268-8,  la que actúa representada, según consta en la escritura pública de fecha 5 de agosto de 2020, otorgada en la Notaría de Santiago, de doña Linda Scarlett Bosch Jiménez, repertorio N° 2.281-2020, por don JAIME ANDRÉS FABREGAT FLEISCHMANN, chileno, casado y separado totalmente de bienes, ingeniero civil industrial, cédula nacional de identidad N° 13.026.763-7, ambos domiciliados en calle Augusto Leguía Sur N° 79, oficina 1110, de la comuna de Las Condes, Ciudad de Santiago, Región Metropolitana, en adelante “EL FACTOR” o “EL CESIONARIO” o “EL MANDATARIO”, exponen que han convenido en la celebración del siguiente contrato de cesión de créditos y de mandato:

PRIMERO: “EL CLIENTE” producto de su giro, ha emitido las facturas, y ha recibido letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles que se individualizan en el anexo que, firmado por las partes se agrega al presente contrato el que para todos los efectos legales, se entenderá formar parte integrante del mismo.
SEGUNDO: Se deja expresa constancia por “EL CLIENTE” que todas las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles señaladas en el anexo indicado han sido entregadas a los compradores de las mercaderías y/o servicios que aparecen descritas en ellas, las que corresponden a operaciones comerciales, reales y lícitas, habiendo transcurrido en el caso de las facturas, en  exceso el plazo de 8 días estipulado en el artículo 160 del código de comercio para los efectos de reclamar del contenido de las mismas, sin que se hubiere formulado tal reclamo, por lo que se entiendan irrevocablemente aceptadas, y cumplir con los demás requisitos de la Ley 19983 y sus modificaciones, declaración que es elemento esencial y determinante para la celebración del presente contrato. Declara “EL CEDENTE” que las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles emitidas llevan el número de su Rol Único Tributario y que para los efectos del pago de la factura, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles se estará a la fecha indicada en el documento, sin que se pueda tomar en consideración cualquier otra fecha que pueda establecerse en el resto del documento. Se deja constancia que el pago del Impuesto de la Ley sobre Impuesto a las Ventas y Servicios y cualquier otro impuesto, correspondiente a cada una de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles cedidas es una obligación de  “EL CLIENTE”, la que en ningún caso será asumida por “EL FACTOR”.-
TERCERO: El presente contrato de cesión se celebra entre las partes en mérito y sobre la base de las estipulaciones contenidas en el contrato de factoring suscrito entre ellas, el que se considera parte integrante del presente contrato para todos los efectos legales.-
CUARTO: Por el presente contrato “EL CLIENTE” vende, cede y transfiere a “EL FACTOR” todos y cada uno de los créditos emanados de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles individualizadas en el anexo ya referido, declarando este último comprarlas, aceptarlas y adquirirlas para sí. ““EL FACTOR” deberá pagar a “EL CEDENTE”  en la misma moneda en que los créditos se encuentren expresados, salvo que las partes acuerden algo distinto por escrito.
QUINTO: El precio de la cesión es de $ <b> {{number_format($application->invoices->sum('disbursement') + $application->invoices->sum('surplus')  ,0,",",".")}}</b>, pesos moneda nacional o dólares de los Estados Unidos de América, que “EL FACTOR”  paga al cedente de la siguiente forma: a) Con <b>${{number_format($application->invoices->sum('disbursement')  ,0,",",".")}}</b>, pesos moneda nacional o dólares de los Estados Unidos de América, que se pagan en este acto al contado, mediante transferencia bancaria (electrónica), vía LBTR (liberación bruta en tiempo real) o a través de depósito en la cuenta corriente de ”EL CEDENTE” y que éste declara haber recibido conforme y a su entera satisfacción y, b) Con <b>${{number_format($application->invoices->sum('surplus')  ,0,",",".")}}</b>, pesos moneda nacional o dólares de los Estados Unidos de América, sujeto a la condición suspensiva de que los deudores paguen el 100% del valor de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles a su vencimiento, y que se podrán pagar mediante abonos parciales a partir del 2º día hábil bancario siguiente a la fecha en que “EL FACTOR” reciba el producto de la cobranza de los créditos que constan de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles cedidas por el presente instrumento, o si fuere el caso, desde que “EL CEDENTE” entregue a “EL FACTOR” el producto de dicha cobranza. Si el(los) deudor(es) cedido(s) paga(n) una factura, letra de cambio, cheque, pagaré y otro documento de crédito o mercantil después de la fecha de vencimiento estipulado en el documento, se deducirá del monto referido en la letra b) de esta cláusula, una multa equivalente hasta un 0.15% del monto total de los créditos que se adquieren. La referida multa se aplicará sobre la base del monto de los créditos no pagados oportunamente por los deudores y por cada día de retardo y hasta la fecha en que “EL FACTOR” reciba efectivamente el pago. En todo caso, se deja expresamente establecido que ““EL FACTOR” podrá, a título de garantía, retener del producto de la cobranza de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles adquiridas, el monto a que se refiere esta letra, con el fin de caucionar el exacto y oportuno cumplimiento de las obligaciones que el presente contrato le impone al cedente. “EL FACTOR” podrá imputar la cantidad que retiene por este concepto a cualquier obligación que tenga pendiente “EL CEDENTE” a su favor, sea que provenga de  este contrato o de cualquier otra operación de factoring o de descuento de efectos de comercio. “EL CLIENTE” otorga a “EL FACTOR” instrucciones irrevocables de llenado de esta cláusula, en cuanto ordena que el  precio de la cesión deberá ser estampado en este instrumento, a contar de las veinticuatro horas siguientes  después de llegada a oficinas del factoring la cesión firmada con su respectivo carta guía y copia de los documentos mercantiles, cheques, letras de cambio, facturas y demás efectos de comercio y una vez hecha las verificaciones pertinentes y producida la liquidación de la compra de los respectivos créditos. Estas instrucciones se otorgan con el carácter de irrevocables.
SEXTO: Se deja constancia que “EL CEDENTE” se hace expresamente responsable de la existencia de los créditos de que dan cuenta las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles individualizadas en el anexo señalado en la cláusula primera del presente instrumento, como asimismo, de la solvencia de cada uno de los deudores a cuyo favor se emitieron las respectivas facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles. La responsabilidad que asume “EL CEDENTE” comprende la solvencia presente y futura del deudor de la respectiva factura, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles, hasta su completo e íntegro pago y por el valor total de ella. En consecuencia, en el evento que por cualquier causa no se pague una factura, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles o el deudor pague directamente al cedente, “EL FACTOR” será reembolsado directamente por “EL CLIENTE”, y/o descontará el valor correspondiente del monto retenido a título de garantía, establecido en la letra b) de la cláusula precedente. Asimismo ““EL CEDENTE” faculta irrevocablemente a “EL FACTOR” para descontar dicho valor del precio que debe pagar por la cesión de otros créditos que consten en las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles. Será responsabilidad de “EL CLIENTE” informar todos los cambios de sus apoderados y/o representantes legales a “EL FACTOR”. “EL CLIENTE”

<div style="page-break-before: always;" ></div>

deberá enviar las escrituras que dan cuenta de este cambio, al domicilio de “EL FACTOR”; ”; su omisión lo hará responsable frente a “EL FACTOR”.-    
SEPTIMO: En este acto “EL CLIENTE” entrega al “EL CESIONARIO” las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles individualizadas en el anexo señalado en la cláusula primera de este instrumento, a cada una de las cuales se le ha estampado la siguiente leyenda: "El crédito representado por el presente documento ha sido cedido a "COMEXTECH SpA", con domicilio en   calle Augusto Leguía Sur N° 79, oficina 1110, de la comuna de Las Condes, Ciudad de Santiago, Región Metropolitana, a quien se deberá efectuar el pago del mismo para que ésta se entienda cancelada. Lugar de otorgamiento, fecha de la cesión y firma del cedente.".- 
OCTAVO: A mayor abundamiento y para el caso de que no sea posible notificar legalmente la cesión, “EL CLIENTE”, por el presente instrumento, faculta y otorga mandato irrevocable a “EL FACTOR”, para que en su nombre y representación cobre y perciba directamente del deudor y/o girador y/o suscriptor lo que éste deba pagar por los documentos que se cedan, y además, quedando facultado el mandatario para retirar y cancelar cheques y otros documentos mercantiles o bancarios, correspondan éstos a operaciones de factoring realizadas en virtud del presente documento o, bien, a cualquier otra operación comercial entre “EL CLIENTE” y terceros, cobrar y percibir su valor, sean estos nominativos o no, depositarlos en cuentas corrientes, de hacerlos protestar, endosarlos en cobranza, ejercer todas las acciones que en derecho correspondan al cedente para obtener el pago íntegro y oportuno del importe de los referidos documentos, otorgar recibos y cancelaciones y cualquier otro documento que sea exigido para dar cumplido término al presente mandato.  Se incluye en las facultades conferidas la representación judicial con todas las atribuciones contempladas en ambos incisos del artículo séptimo del Código de Procedimiento Civil, las que se dan por reproducidas expresamente, sin perjuicio de las facultades que se otorgan a “EL FACTOR” por el presente instrumento, “EL CEDENTE” y a “EL FACTOR” concuerdan que frente al incumplimiento por parte del deudor de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles adquiridas, a “EL FACTOR” podrá, además de ejercer el mandato de cobro judicial, proceder conforme a las instrucciones que al respecto se otorgan en la cláusula siguiente del presente instrumento.  “EL CLIENTE” autoriza expresa e irrevocablemente a  “EL FACTOR” para conservar, retener y pagar en su propio beneficio las sumas de dinero que perciba con motivo del encargo encomendado, hasta el importe que le adeude “EL CLIENTE” por concepto de cualquier contrato de cesión de créditos, liberándolo de la obligación de rendir cuenta, ya que corresponde al valor de las facturas, cheques, pagarés, letras de cambio y otros efectos de comercio o documentos de crédito, según corresponda, adquiridas por dicha sociedad y que son por lo tanto de su propiedad.  “EL FACTOR” representada en la forma indicada, acepta el mandato que se le confiere por el presente instrumento en los términos señalados. “EL CEDENTE” y/o mandante autoriza  a “EL FACTOR” a enviar los antecedentes de los deudores morosos para que sean ingresados al sistema de morosidad financiera de Dicom Equifax y a cualquier otro sistema financiero de morosidad que se cree en el futuro. “EL CLIENTE” autoriza expresamente a a “EL FACTOR” para poder entregar, disponer y/o requerir de información financiera y legal a Bancos o Instituciones financieras. -  
NOVENO: Con el objeto de hacer efectiva la eventual responsabilidad que podría corresponder a “EL CLIENTE” por la solvencia presente y futura de los deudores de las facturas, letras de cambio, cheques, pagarés y otros documentos de crédito o mercantiles que se ceden por el presente instrumento según se indica en la cláusula primera, o por incumplimiento por parte de “EL CLIENTE” de cualquiera de las obligaciones que le impone el presente contrato, “EL CEDENTE” suscribió, sin ánimo de novar, pagaré a plazo y a la orden de  “EL FACTOR” con algunas menciones en blanco, otorgando “EL CLIENTE” a  “EL FACTOR” las instrucciones irrevocables de llenado que se indican en el mandato que “EL CEDENTE” suscribe conjuntamente con el pagaré. 
DECIMO: Las diferencias de cambios negativas o positivas producidas en operaciones de factoring en dólares de los Estados Unidos de América, que representen los créditos que se cedan “AL FACTOR”, serán siempre de cargo o a favor de “EL CLIENTE”, respectivamente.-
DECIMO PRIMERO: Todos los gastos, derechos e impuestos que se generen con ocasión del presente contrato serán de cargo de ““EL CEDENTE”. Asimismo, será de su cargo el pago del impuesto de Timbres y Estampillas que afecte a el o los pagarés que se suscriban.
DÉCIMO SEGUNDO: Se faculta al portador de copia del presente instrumento, para requerir a un ministro de fe las notificaciones o acreditar las aceptaciones que procedan, para la completa legalización del presente instrumento.
DÉCIMO TERCERO: Para todos los efectos legales las partes fijan domicilio en la ciudad y comuna de Santiago y se someten a la competencia de sus Tribunales de Justicia. 
DECIMO CUARTO: Por su parte, “EL CLIENTE” declara expresamente que sus fondos o la fuente de los fondos de su representada son de origen lícito y no han sido generados a través de los delitos establecidos en la Ley N 20.393 ni en contravención a ninguna otra ley, reglamento o normativa vigente.  En consecuencia garantiza que no ha realizado ni realizará ninguna actividad que pudiera constituir una violación a la legislación nacional, en especial a la Ley N 20.393 que pudiera someter a  “EL FACTOR” a responsabilidad o pena alguna de conformidad con las mismas.
Previa lectura, firman las partes en tres ejemplares de la misma fecha y tenor, quedando uno en poder de “EL CLIENTE” y dos en poder de “EL FACTOR”.-

</p>

<p>
    
</p>


</div>

<br><br><br><br><br>

<p style="text-align: center">
    ____________________________________________ <br>
    Sr. <b>{{$application->user->name}}</b> <br>
p.p. <b>{{$application->user->company->name}}</b>

</p>
<br><br><br>

<p style="text-align: center">
_________________________________   <br>     
JAIME ANDRÉS FABREGAT FLEISCHMANN <br>
p.p. COMEXTECH SpA

</p>


</body>
</html>