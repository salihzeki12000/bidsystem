<table class="table table-bordered">
    <tr>
        <th>Group</th>
        <th>Item</th>
        <th>Job Request</th>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <th>{{ $bid['company']['company_name'] }}</th>
            @endforeach
        @endif
    </tr>
    <tr>
        <td rowspan="11">Commercial</td>
        <td>Price</td>
        <td>{{ $job['existing_budget'] }}</td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>{{ $bid['est_budget'] }}</td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Equipments</td>
        <td>
            @if(!empty($job['equipment']) && count($job['equipment']) > 0)
                @foreach($job['equipment'] as $equipment_key => $equipment)
                    {{ $equipment['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['equipment']) && count($bid['company']['equipment']) > 0)
                        @foreach($bid['company']['equipment'] as $equipment_lsp)
                            {{ $equipment_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Safety & Health</td>
        <td>
            @if(!empty($job['safety_health']) && count($job['safety_health']) > 0)
                @foreach($job['safety_health'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['safety_health']) && count($bid['company']['safety_health']) > 0)
                        @foreach($bid['company']['safety_health'] as $sh_lsp)
                            {{ $sh_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Environmental</td>
        <td>
            @if(!empty($job['environmental']) && count($job['environmental']) > 0)
                @foreach($job['environmental'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['environmental']) && count($bid['company']['environmental']) > 0)
                        @foreach($bid['company']['environmental'] as $en_lsp)
                            {{ $en_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Technology</td>
        <td>
            @if(!empty($job['technology']) && count($job['technology']) > 0)
                @foreach($job['technology'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['technology']) && count($bid['company']['technology']) > 0)
                        @foreach($bid['company']['technology'] as $tech_lsp)
                            {{ $tech_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Liability and Claims</td>
        <td>
            @if(!empty($job['liability_and_claims']) && count($job['liability_and_claims']) > 0)
                @foreach($job['liability_and_claims'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['liability_and_claims']) && count($bid['company']['liability_and_claims']) > 0)
                        @foreach($bid['company']['liability_and_claims'] as $lac_lsp)
                            {{ $lac_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Blacklist</td>
        <td>
            @if(!empty($job['blacklist']) && count($job['blacklist']) > 0)
                @foreach($job['blacklist'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['blacklist']) && count($bid['company']['blacklist']) > 0)
                        @foreach($bid['company']['blacklist'] as $blacklist_lsp)
                            {{ $blacklist_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Innovative Power</td>
        <td>
            @if(!empty($job['innovative_power']) && count($job['innovative_power']) > 0)
                @foreach($job['innovative_power'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['innovative_power']) && count($bid['company']['innovative_power']) > 0)
                        @foreach($bid['company']['innovative_power'] as $ip_lsp)
                            {{ $ip_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Financial Strength and HR size</td>
        <td></td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>{{ $bid['company']['no_of_employees'] }}</td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Industry Reputation</td>
        <td></td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    <p>Cost Competitiveness: {{ $bid['company']['c'] }}</p>
                    <p>Environmental Responsibility: {{ $bid['company']['e'] }}</p>
                    <p>Technology: {{ $bid['company']['t'] }}</p>
                    <p>Responsiveness: {{ $bid['company']['r'] }}</p>
                    <p>Assurance of Supply: {{ $bid['company']['a'] }}</p>
                    <p>Quality: {{ $bid['company']['q'] }}</p>
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Duration in Business</td>
        <td></td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    {{ $bid['company']['duration_in_business'] }} Years
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td rowspan="6">Quality</td>
        <td>Quality</td>
        <td>
            @if(!empty($job['quality']) && count($job['quality']) > 0)
                @foreach($job['quality'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['quality']) && count($bid['company']['quality']) > 0)
                        @foreach($bid['company']['quality'] as $quality_lsp)
                            {{ $quality_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Certification</td>
        <td>
            @if(!empty($job['certification']) && count($job['certification']) > 0)
                @foreach($job['certification'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['certification']) && count($bid['company']['certification']) > 0)
                        @foreach($bid['company']['certification'] as $certification_lsp)
                            {{ $certification_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Past Experiences</td>
        <td>
            @if(!empty($job['past_experiences']) && count($job['past_experiences']) > 0)
                @foreach($job['past_experiences'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['past_experiences']) && count($bid['company']['past_experiences']) > 0)
                        @foreach($bid['company']['past_experiences'] as $pe_lsp)
                            {{ $pe_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Past Projects Awarded</td>
        <td></td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    {{ $bid['company']['past_project_awarded'] }}
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Security</td>
        <td>
            @if(!empty($job['security']) && count($job['security']) > 0)
                @foreach($job['security'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['security']) && count($bid['company']['security']) > 0)
                        @foreach($bid['company']['security'] as $security_lsp)
                            {{ $security_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Trade Compliance</td>
        <td>
            @if(!empty($job['trade_compliance']) && count($job['trade_compliance']) > 0)
                @foreach($job['trade_compliance'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['trade_compliance']) && count($bid['company']['trade_compliance']) > 0)
                        @foreach($bid['company']['trade_compliance'] as $tc_lsp)
                            {{ $tc_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td rowspan="8">Sustainability</td>
        <td>Requirements</td>
        <td>
            @if(!empty($job['requirements']) && count($job['requirements']) > 0)
                @foreach($job['requirements'] as $requirement_key => $requirement)
                    {{ $requirement['requirement'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['requirements_with_name_only']) && count($bid['company']['requirements_with_name_only']) > 0)
                        @foreach($bid['company']['requirements_with_name_only'] as $requirement_lsp)
                            {{ $requirement_lsp['requirement'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Potentials</td>
        <td>
            @if(!empty($job['potentials']) && count($job['potentials']) > 0)
                @foreach($job['potentials'] as $potential_key => $potential)
                    {{ $potential['potential'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['potentials_with_name_only']) && count($bid['company']['potentials_with_name_only']) > 0)
                        @foreach($bid['company']['potentials_with_name_only'] as $potential_lsp)
                            {{ $potential_lsp['potential'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Highlights</td>
        <td>
            @if(!empty($job['highlights']) && count($job['highlights']) > 0)
                @foreach($job['highlights'] as $highlight_key => $highlight)
                    {{ $highlight['highlight'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['highlight']) && count($bid['company']['highlight']) > 0)
                        @foreach($bid['company']['highlight'] as $highlight)
                            {{ $highlight['highlight'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Additional Descriptions</td>
        <td>
            {!! $job['additional_description'] !!}
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    {!! $bid['additional_description'] !!}
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Special Requests</td>
        <td>
            {!! $job['special_request'] !!}
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    {!! $bid['reply_to_special_request'] !!}
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Assurance of Supply</td>
        <td>
            @if(!empty($job['assurance_of_supply']) && count($job['assurance_of_supply']) > 0)
                @foreach($job['assurance_of_supply'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['assurance_of_supply']) && count($bid['company']['assurance_of_supply']) > 0)
                        @foreach($bid['company']['assurance_of_supply'] as $aos_lsp)
                            {{ $aos_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Responsiveness</td>
        <td>
            @if(!empty($job['responsiveness']) && count($job['responsiveness']) > 0)
                @foreach($job['responsiveness'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['responsiveness']) && count($bid['company']['responsiveness']) > 0)
                        @foreach($bid['company']['responsiveness'] as $r_lsp)
                            {{ $r_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td>Scalability/Growth</td>
        <td>
            @if(!empty($job['scalability_growth']) && count($job['scalability_growth']) > 0)
                @foreach($job['scalability_growth'] as $sh_key => $sh)
                    {{ $sh['details'] }}<br>
                @endforeach
            @endif
        </td>
        @if(!empty($bids) && count($bids) > 0)
            @foreach($bids as $bid)
                <td>
                    @if(!empty($bid['company']['scalability_growth']) && count($bid['company']['scalability_growth']) > 0)
                        @foreach($bid['company']['scalability_growth'] as $sg_lsp)
                            {{ $sg_lsp['details'] }}<br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        @endif
    </tr>
</table>