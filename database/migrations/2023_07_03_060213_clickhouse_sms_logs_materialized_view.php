<?php


use PhpClickHouseLaravel\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::write('drop view if exists sms_sendlogs_mv');
        static::write("CREATE MATERIALIZED VIEW msgr.sms_sendlogs_mv
        ENGINE = MergeTree()
        ORDER BY(sms_id)
        AS
        SELECT 
            MAX(sms_id) as sms_id,MAX(sent_at) As date, MAX(sms_routing_route_id) As sms_routing_route_id, sms_campaign_id, SUM(sent_at is not null) AS sent_count, SUM(cost_platform_cost + cost_user_vendor_cost - cost_platform_profit) as cost,
            SUM(is_clicked is not null) AS clicks, SUM(is_lead is not null) AS leads, SUM(is_sale is not null) AS sales
            FROM msgr.sms_sendlogs
            GROUP BY sms_campaign_id 
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
