<div class="row">
    <div class="lgsecurity_list col col-lg-12">
        <div id="lgsecurity_result">
            <div class="lgsecurity_result_success alert alert-success"{if isset($lgsecurity_result) && $lgsecurity_result > 0} style="display: none;"{/if}>
                {l s='Your system seems to be right, there is not any PHPunit libray detected.' mod='lgsecurity'}
            </div>
            <div class="lgsecurity_result_error alert alert-danger"{if isset($lgsecurity_result) && $lgsecurity_result == 0} style="display: none;"{/if}>
                {l s='Your system could be compromised, seems to have PHPunit libray installed. Please look at the results to fix it.' mod='lgsecurity'}
                {l s='You could have been infected, if you don\'t know how proceed you will need a specialized technical assistance,' mod='lgsecurity'}
                <a href="https://www.lineagrafica.es/contacto/" target="_blank">{l s='please contact us in order to get help you.' mod='lgsecurity'}</a>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th>{l s='Path'  mod='lgsecurity'}</th>
                <th>{l s='Status' mod='lgsecurity'}</th>
                <th>{l s='Date'  mod='lgsecurity'}</th>
                <th><button id="lgsecurity_scan_button">{l s='Scan' mod='lgsecurity'}</button></th>
            </tr>
            </thead>
            <tbody>
            {include file='./list_content.tpl'}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
