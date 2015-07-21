pipelinedeals-php-api
=====================
> **Please note that I am not longer continuing active development since I've stopped using PipelineDeals and switched from PHP to Python. I am more than happy to accept pull requests though!**

Table of Contents
-----------------
<ol>
	<li>Requirements</li>
	<li>Usage</li>
	<li>Examples</li>
</ol>

Requirements
------------
<ul>
	<li>PHP with cURL</li>
	<li>Pipelinedeals Account with API-Access</li>
</ul>

Usage
-----
<h3>Instantiate Class</h3>
<code>
	$pda = new PDAdapter(api-key,custom-base-url);
</code>
<ul>
	<li>api-key: Your Pipelinedeals API-Key</li>
	<li>custom-base-url: Set a custom base url for API requests (advanced users only, see source for further information)</li>
</ul>

<h3>Set Request Method (optional)</h3>
<code>$pda->setMethod(method);</code>
<ul>
	<li>method: The method of your request. Either 'get' (default), 'post' or 'put'</li>
</ul>

<h3>Do a Request to Pipelinedeals</h3>
<code>$result = $pda->doRequest(resource, conditions, page, request-data)</code>
<ul>
	<li>resource: the wanted Pipelinedeals resource. E.g.: 'people', see the Pipelinedeals-API-Documentation for further information (<a href="http://www.pipelinedeals.com/developers/api">http://www.pipelinedeals.com/developers/api</a>)</li>
	<li>conditions (optional): Conditions in key=>value array, e.g.: "array('[deal_created][from_date]'=>'2011-01-01','[deal_created][to_date]' => '2012-01-01')"</li>
	<li>page (optional): The wanted page as integer, e.g.: "2"</li>
	<li>request-data (optional): Needed for requests which send data with themselves, for e.g. creating a deal.</li>
</ul>

Examples
--------
<h3>Full example getting a list of all people</h3>
	$pda = new PDAdapter($api_key);
	$result = $pda->doRequest("people");

That's only two lines - see how easy that is?
