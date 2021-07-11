--extractdecypherpayne0529
-- PostgreSQL database dump
--

-- Dumped from database version 11.2
-- Dumped by pg_dump version 11.2

-- Started on 2020-12-09 12:13:53

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 196 (class 1259 OID 60822)
-- Name: main_buses; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_buses (
    id integer NOT NULL,
    number character varying NOT NULL,
    operator_id integer,
    platform_id integer,
    exterior_campaign_id integer,
    interior_campaign_id integer,
    bus_status_id integer DEFAULT 1 NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    bus_depot_id integer,
    bus_size_id integer
);


--
-- TOC entry 197 (class 1259 OID 60831)
-- Name: main_buses_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_buses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3234 (class 0 OID 0)
-- Dependencies: 197
-- Name: main_buses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_buses_id_seq OWNED BY public.main_buses.id;


--
-- TOC entry 198 (class 1259 OID 60833)
-- Name: main_campaigns; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_campaigns (
    id integer NOT NULL,
    inventory_id integer,
    platform_id integer,
    bus_size_id integer,
    price_id integer,
    quantity integer,
    start_date date NOT NULL,
    end_date date NOT NULL,
    user_id integer NOT NULL,
    vendor_id integer,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    name text,
    renewal_stage_id integer DEFAULT 1
);


--
-- TOC entry 199 (class 1259 OID 60842)
-- Name: main_campaigns_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_campaigns_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3235 (class 0 OID 0)
-- Dependencies: 199
-- Name: main_campaigns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_campaigns_id_seq OWNED BY public.main_campaigns.id;


--
-- TOC entry 200 (class 1259 OID 60844)
-- Name: main_print_orders; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_print_orders (
    id integer NOT NULL,
    campaign_id integer,
    printer_id integer,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    link text DEFAULT 'click here'::text,
    approved boolean DEFAULT false,
    quantity integer NOT NULL,
    comments text,
    bus_codes text
);


--
-- TOC entry 201 (class 1259 OID 60853)
-- Name: main_print_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_print_orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3236 (class 0 OID 0)
-- Dependencies: 201
-- Name: main_print_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_print_orders_id_seq OWNED BY public.main_print_orders.id;


--
-- TOC entry 202 (class 1259 OID 60855)
-- Name: main_reports; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_reports (
    id integer NOT NULL,
    date date NOT NULL,
    image text,
    video text,
    comments text,
    vendor_id integer NOT NULL,
    ref_bus_id integer,
    campaign_id integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    type_id integer
);


--
-- TOC entry 203 (class 1259 OID 60862)
-- Name: main_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3237 (class 0 OID 0)
-- Dependencies: 203
-- Name: main_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_reports_id_seq OWNED BY public.main_reports.id;


--
-- TOC entry 204 (class 1259 OID 60864)
-- Name: main_transactions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_transactions (
    id integer NOT NULL,
    campaign_id integer NOT NULL,
    operator_id integer NOT NULL,
    quantity integer NOT NULL,
    status_id integer DEFAULT 1 NOT NULL,
    print_status_id integer DEFAULT 1 NOT NULL,
    payment_status_id integer DEFAULT 1 NOT NULL,
    created_by integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    payment_date date,
    start_date date,
    end_date date,
    price_id integer
);


--
-- TOC entry 205 (class 1259 OID 60872)
-- Name: main_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_transactions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3238 (class 0 OID 0)
-- Dependencies: 205
-- Name: main_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_transactions_id_seq OWNED BY public.main_transactions.id;


--
-- TOC entry 206 (class 1259 OID 60874)
-- Name: main_users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.main_users (
    id integer NOT NULL,
    name text NOT NULL,
    reportsto integer,
    username text NOT NULL,
    password text NOT NULL,
    email character varying(250),
    user_type integer,
    vendor_id integer,
    ts timestamp with time zone DEFAULT now()
);


--
-- TOC entry 207 (class 1259 OID 60881)
-- Name: main_users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.main_users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3239 (class 0 OID 0)
-- Dependencies: 207
-- Name: main_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.main_users_id_seq OWNED BY public.main_users.id;


--
-- TOC entry 208 (class 1259 OID 60926)
-- Name: sub_media_allocation; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sub_media_allocation (
    id integer NOT NULL,
    bus_id integer,
    campaign_id integer,
    active boolean DEFAULT false NOT NULL,
    created_by integer,
    ts_created timestamp with time zone DEFAULT now(),
    ts_last_update timestamp with time zone
);


--
-- TOC entry 209 (class 1259 OID 60931)
-- Name: sub_media_allocation_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.sub_media_allocation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3240 (class 0 OID 0)
-- Dependencies: 209
-- Name: sub_media_allocation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.sub_media_allocation_id_seq OWNED BY public.sub_media_allocation.id;


--
-- TOC entry 210 (class 1259 OID 60933)
-- Name: sub_renewal_requests; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sub_renewal_requests (
    id integer NOT NULL,
    campaign_id integer,
    created_by integer,
    ts_created timestamp with time zone,
    ts_last_update timestamp with time zone
);


--
-- TOC entry 211 (class 1259 OID 60936)
-- Name: sub_renewal_requests_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.sub_renewal_requests_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3241 (class 0 OID 0)
-- Dependencies: 211
-- Name: sub_renewal_requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.sub_renewal_requests_id_seq OWNED BY public.sub_renewal_requests.id;


--
-- TOC entry 212 (class 1259 OID 60938)
-- Name: sub_transaction_details; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sub_transaction_details (
    id integer NOT NULL,
    transaction_id integer NOT NULL,
    bus_id integer NOT NULL,
    created_by integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 213 (class 1259 OID 60943)
-- Name: sub_transaction_details_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.sub_transaction_details_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3242 (class 0 OID 0)
-- Dependencies: 213
-- Name: sub_transaction_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.sub_transaction_details_id_seq OWNED BY public.sub_transaction_details.id;


--
-- TOC entry 214 (class 1259 OID 60970)
-- Name: x_bus_depot; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_bus_depot (
    id integer NOT NULL,
    name text NOT NULL
);


--
-- TOC entry 215 (class 1259 OID 60976)
-- Name: x_bus_sizes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_bus_sizes (
    id integer NOT NULL,
    name text
);


--
-- TOC entry 216 (class 1259 OID 60982)
-- Name: x_bus_status; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_bus_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    availability boolean NOT NULL
);


--
-- TOC entry 217 (class 1259 OID 60988)
-- Name: y_operators; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.y_operators (
    id integer NOT NULL,
    name character varying(50),
    shortname character varying(50),
    platform_id integer,
    email character varying,
    contact_name character varying
);


--
-- TOC entry 218 (class 1259 OID 60994)
-- Name: y_platforms; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.y_platforms (
    id integer NOT NULL,
    name character varying(50),
    shortname character varying(50),
    email character varying
);


--
-- TOC entry 219 (class 1259 OID 61000)
-- Name: y_vendors; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.y_vendors (
    id integer NOT NULL,
    name character varying NOT NULL
);


--
-- TOC entry 220 (class 1259 OID 61006)
-- Name: view_all_buses; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_all_buses AS
 SELECT main_buses.id,
    main_buses.number,
    ( SELECT y.name
           FROM public.y_platforms y
          WHERE (y.id = main_buses.platform_id)) AS platform,
    ( SELECT o.name
           FROM public.y_operators o
          WHERE (o.id = main_buses.operator_id)) AS operator,
    ( SELECT c.name
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.exterior_campaign_id)) AS exterior_campaign,
    ( SELECT v.name
           FROM public.y_vendors v
          WHERE (v.id = ( SELECT c.vendor_id
                   FROM public.main_campaigns c
                  WHERE (c.id = main_buses.exterior_campaign_id)))) AS exterior_campaign_vendor,
    ( SELECT c.name
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.interior_campaign_id)) AS interior_campaign,
    ( SELECT v.name
           FROM public.y_vendors v
          WHERE (v.id = ( SELECT c.vendor_id
                   FROM public.main_campaigns c
                  WHERE (c.id = main_buses.interior_campaign_id)))) AS interior_campaign_vendor,
    ( SELECT b.name
           FROM public.x_bus_status b
          WHERE (b.id = main_buses.bus_status_id)) AS bus_status,
    ( SELECT b.name
           FROM public.x_bus_sizes b
          WHERE (b.id = main_buses.bus_size_id)) AS bus_size,
    ( SELECT b.name
           FROM public.x_bus_depot b
          WHERE (b.id = main_buses.bus_depot_id)) AS bus_depot,
    main_buses.ts_created,
    main_buses.ts_last_update,
    main_buses.bus_status_id,
    main_buses.bus_size_id,
    main_buses.bus_depot_id,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.exterior_campaign_id,
    main_buses.interior_campaign_id
   FROM public.main_buses;


--
-- TOC entry 221 (class 1259 OID 61011)
-- Name: view_bus_depot_summary; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_bus_depot_summary AS
 SELECT
        CASE
            WHEN (main_buses.bus_depot_id IS NULL) THEN '<< NO DEPOT ASSIGNED >>'::text
            ELSE ( SELECT x_bus_depot.name
               FROM public.x_bus_depot
              WHERE (x_bus_depot.id = main_buses.bus_depot_id))
        END AS depot,
    count(*) AS total_buses,
    string_agg((main_buses.number)::text, ', '::text) AS bus_codes,
    string_agg((
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN main_buses.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS good_bus_codes,
    string_agg((
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN main_buses.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS bad_bus_codes
   FROM public.main_buses
  GROUP BY main_buses.bus_depot_id;


--
-- TOC entry 222 (class 1259 OID 61016)
-- Name: view_bus_ext_summary_at_a_glance; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_bus_ext_summary_at_a_glance AS
 SELECT
        CASE
            WHEN (main_buses.exterior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END AS brand_status,
    count(
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active,
    count(
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS maintenance,
    count(*) AS total,
    to_char(max(main_buses.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses
  GROUP BY
        CASE
            WHEN (main_buses.exterior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END;


--
-- TOC entry 223 (class 1259 OID 61021)
-- Name: view_bus_int_summary_at_a_glance; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_bus_int_summary_at_a_glance AS
 SELECT
        CASE
            WHEN (main_buses.interior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END AS brand_status,
    count(
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active,
    count(
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS maintenance,
    count(*) AS total,
    to_char(max(main_buses.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses
  GROUP BY
        CASE
            WHEN (main_buses.interior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END;


--
-- TOC entry 224 (class 1259 OID 61026)
-- Name: view_bus_summary; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_bus_summary AS
 SELECT b.exterior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS campaign_name,
    ( SELECT ((main_campaigns.start_date || ' - '::text) || main_campaigns.end_date)
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS period,
    count(b.number) AS buses,
    count(
        CASE
            WHEN (b.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active_working,
    count(
        CASE
            WHEN (b.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS requires_maintenance,
    string_agg(DISTINCT (( SELECT x_bus_status.name
           FROM public.x_bus_status
          WHERE ((x_bus_status.id = b.bus_status_id) AND (x_bus_status.id <> 1))))::text, chr(10)) AS issues,
    string_agg((
        CASE
            WHEN (b.bus_status_id = 1) THEN b.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS good_bus_codes,
    string_agg((
        CASE
            WHEN (b.bus_status_id <> 1) THEN b.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS bad_bus_codes,
    string_agg((b.number)::text, ', '::text) AS bus_codes,
    to_char(max(b.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses b
  GROUP BY b.exterior_campaign_id
  ORDER BY (b.exterior_campaign_id IS NULL), ( SELECT ((main_campaigns.start_date || ' - '::text) || main_campaigns.end_date)
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) DESC;


--
-- TOC entry 225 (class 1259 OID 61031)
-- Name: view_bus_trans_options; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_bus_trans_options AS
 SELECT b.id AS bus_id,
    t.id AS transaction_id,
    b.number,
    b.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = b.platform_id)) AS platform,
    b.operator_id,
    ( SELECT y_operators.name
           FROM public.y_operators
          WHERE (y_operators.id = b.operator_id)) AS operator,
    b.bus_status_id,
    ( SELECT x_bus_status.name
           FROM public.x_bus_status
          WHERE (x_bus_status.id = b.bus_status_id)) AS bus_status,
    t.quantity,
    b.exterior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS exterior_campaign,
    b.interior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.interior_campaign_id)) AS interior_campaign
   FROM public.main_transactions t,
    public.main_buses b
  WHERE (b.operator_id = t.operator_id);


--
-- TOC entry 226 (class 1259 OID 61036)
-- Name: view_buses_assigned; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_buses_assigned AS
 SELECT d.id,
    d.transaction_id,
    ('BUS '::text || (b.number)::text) AS bus
   FROM public.sub_transaction_details d,
    public.main_buses b
  WHERE (b.id = d.bus_id);


--
-- TOC entry 227 (class 1259 OID 61040)
-- Name: view_buses_exterior; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_buses_exterior AS
 SELECT main_buses.id,
    main_buses.number,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.exterior_campaign_id,
    main_buses.exterior_campaign_id AS campaign_id,
    main_buses.bus_status_id,
    main_buses.bus_depot_id,
    main_buses.ts_created,
    main_buses.ts_last_update,
    ( SELECT c.vendor_id
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.exterior_campaign_id)) AS vendor_id
   FROM public.main_buses;


--
-- TOC entry 228 (class 1259 OID 61044)
-- Name: view_buses_interior; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_buses_interior AS
 SELECT main_buses.id,
    main_buses.number,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.interior_campaign_id,
    main_buses.interior_campaign_id AS campaign_id,
    main_buses.bus_status_id,
    main_buses.bus_depot_id,
    main_buses.ts_created,
    main_buses.ts_last_update,
    ( SELECT c.vendor_id
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.interior_campaign_id)) AS vendor_id
   FROM public.main_buses;


--
-- TOC entry 229 (class 1259 OID 61048)
-- Name: view_campaign_status; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_campaign_status AS
SELECT
    NULL::integer AS id,
    NULL::text AS name,
    NULL::bigint AS pending,
    NULL::bigint AS approved,
    NULL::bigint AS denied,
    NULL::text AS status,
    NULL::text AS status_matrix,
    NULL::text AS status_json;


--
-- TOC entry 230 (class 1259 OID 61052)
-- Name: x_payment_status; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_payment_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


--
-- TOC entry 231 (class 1259 OID 61058)
-- Name: x_print_stage; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_print_stage (
    id integer NOT NULL,
    name text
);


--
-- TOC entry 232 (class 1259 OID 61064)
-- Name: x_transaction_status; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_transaction_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    admin_name character varying,
    operator_name character varying
);


--
-- TOC entry 233 (class 1259 OID 61070)
-- Name: y_inventory; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.y_inventory (
    id integer NOT NULL,
    name text
);


--
-- TOC entry 234 (class 1259 OID 61076)
-- Name: z_price_settings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.z_price_settings (
    id integer NOT NULL,
    platform_id integer NOT NULL,
    inventory_id integer NOT NULL,
    print_stage_id integer,
    bus_size_id integer,
    details text,
    max_limit integer,
    min_limit integer,
    price bigint,
    operator_fee bigint,
    agency_fee bigint,
    lamata_fee bigint,
    lasaa_fee bigint,
    printers_fee bigint,
    active boolean DEFAULT false NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL
);


--
-- TOC entry 235 (class 1259 OID 61084)
-- Name: view_campaigns_pending; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_campaigns_pending AS
 SELECT t.payment_date,
    t.start_date,
    t.end_date,
    i.name AS inventory,
    p.shortname AS platform,
    o.shortname AS operator,
    bs.name AS bus_size,
    pr.name AS print_stage,
    c.name AS campaign,
    v.name AS vendor,
    t.quantity,
    ps.price,
    ps.operator_fee,
    ps.lamata_fee,
    ps.agency_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ts.name AS transaction_status,
    xps.name AS payment_status,
    t.id AS transaction_id,
    t.payment_status_id,
    t.status_id,
    c.vendor_id,
    ps.inventory_id,
    ps.platform_id,
    t.operator_id,
    ps.bus_size_id
   FROM public.main_campaigns c,
    public.main_transactions t,
    public.z_price_settings ps,
    public.y_inventory i,
    public.y_platforms p,
    public.y_operators o,
    public.x_bus_sizes bs,
    public.x_print_stage pr,
    public.y_vendors v,
    public.x_transaction_status ts,
    public.x_payment_status xps
  WHERE ((c.id = t.campaign_id) AND (t.price_id = ps.id) AND (ps.inventory_id = i.id) AND (ps.platform_id = p.id) AND (ps.bus_size_id = bs.id) AND (ps.print_stage_id = pr.id) AND (t.operator_id = o.id) AND (c.vendor_id = v.id) AND (t.status_id = ts.id) AND (t.payment_status_id = xps.id) AND (t.payment_status_id = 2) AND (t.status_id = 4))
  ORDER BY t.id DESC;


--
-- TOC entry 236 (class 1259 OID 61089)
-- Name: x_user_types; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_user_types (
    id integer NOT NULL,
    name character varying NOT NULL
);


--
-- TOC entry 237 (class 1259 OID 61095)
-- Name: view_operators; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_operators AS
 SELECT u.id AS user_id,
    u.name,
    u.email,
    u.vendor_id,
    ut.id AS operator_id,
    ut.name AS operator
   FROM public.main_users u,
    public.x_user_types ut
  WHERE ((u.user_type = ut.id) AND (ut.id = 5));


--
-- TOC entry 238 (class 1259 OID 61099)
-- Name: view_operators_platforms; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_operators_platforms WITH (security_barrier='false') AS
 SELECT c.id AS campaign_id,
    c.platform_id AS campaign_platform_id,
    o.id AS operator_id,
    o.name AS operator_name
   FROM public.main_campaigns c,
    public.y_operators o
  WHERE (o.platform_id = c.platform_id);


--
-- TOC entry 239 (class 1259 OID 61103)
-- Name: x_print_status; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_print_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


--
-- TOC entry 240 (class 1259 OID 61109)
-- Name: view_payments_pending; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_payments_pending AS
 SELECT t.id AS transaction_id,
    c.id AS campaign_id,
    c.name AS campaign_name,
    t.quantity,
    xta.name AS transaction_status,
    xpr.name AS print_status,
    xpa.name AS payment_status,
    t.start_date,
    t.end_date,
    v.name AS vendor,
    o.name AS operator,
    p.name AS platform,
    i.name AS inventory,
    bs.name AS bus_size,
    pst.name AS print_stage,
    ps.price,
    ps.operator_fee,
    ps.agency_fee,
    ps.lamata_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ps.details AS price_details
   FROM public.main_transactions t,
    public.y_operators o,
    public.main_campaigns c,
    public.y_platforms p,
    public.y_inventory i,
    public.y_vendors v,
    public.z_price_settings ps,
    public.x_print_status xpr,
    public.x_payment_status xpa,
    public.x_transaction_status xta,
    public.x_bus_sizes bs,
    public.x_print_stage pst
  WHERE ((t.campaign_id = c.id) AND (t.operator_id = o.id) AND (c.inventory_id = i.id) AND (c.platform_id = p.id) AND (t.price_id = ps.id) AND (c.vendor_id = v.id) AND (t.payment_status_id = xpa.id) AND (t.print_status_id = xpr.id) AND (t.status_id = xta.id) AND (c.bus_size_id = bs.id) AND (ps.print_stage_id = pst.id) AND (t.payment_status_id = 1) AND (((now())::date - (t.ts_created)::date) < 60))
  ORDER BY t.id DESC;


--
-- TOC entry 241 (class 1259 OID 61114)
-- Name: view_pricing_all; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_pricing_all AS
 SELECT p.id,
    p.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = p.platform_id)) AS platform,
    p.inventory_id,
    ( SELECT y_inventory.name
           FROM public.y_inventory
          WHERE (y_inventory.id = p.inventory_id)) AS inventory,
    p.print_stage_id,
    ( SELECT x_print_stage.name
           FROM public.x_print_stage
          WHERE (x_print_stage.id = p.print_stage_id)) AS print_stage,
    p.bus_size_id,
    ( SELECT x_bus_sizes.name
           FROM public.x_bus_sizes
          WHERE (x_bus_sizes.id = p.bus_size_id)) AS bus_size,
    p.details,
    p.max_limit,
    p.min_limit,
    p.price,
    p.operator_fee,
    p.agency_fee,
    p.lamata_fee,
    p.lasaa_fee,
    p.printers_fee,
    p.active
   FROM public.z_price_settings p;


--
-- TOC entry 242 (class 1259 OID 61119)
-- Name: view_pricing_initial; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_pricing_initial AS
 SELECT p.id,
    p.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = p.platform_id)) AS platform,
    p.inventory_id,
    ( SELECT y_inventory.name
           FROM public.y_inventory
          WHERE (y_inventory.id = p.inventory_id)) AS inventory,
    p.print_stage_id,
    ( SELECT x_print_stage.name
           FROM public.x_print_stage
          WHERE (x_print_stage.id = p.print_stage_id)) AS print_stage,
    p.bus_size_id,
    ( SELECT x_bus_sizes.name
           FROM public.x_bus_sizes
          WHERE (x_bus_sizes.id = p.bus_size_id)) AS bus_size,
    p.details,
    p.max_limit,
    p.min_limit,
    p.price,
    p.operator_fee,
    p.agency_fee,
    p.lamata_fee,
    p.lasaa_fee,
    p.printers_fee,
    p.active
   FROM public.z_price_settings p
  WHERE (p.print_stage_id = 1);


--
-- TOC entry 243 (class 1259 OID 61124)
-- Name: view_pricing_options; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_pricing_options AS
 SELECT p.id AS price_id,
    c.price_id AS requested_price_id,
    c.id AS campaign_id,
    (((p.platform)::text || ' | '::text) || p.inventory) AS platform_inventory,
    ((((((('N '::text || to_char(p.price, '999,999.99'::text)) || ' | '::text) || p.bus_size) || ' | '::text) || p.print_stage) || ' | '::text) || p.details) AS price_details
   FROM public.main_campaigns c,
    public.view_pricing_all p
  WHERE ((p.inventory_id = c.inventory_id) AND (p.platform_id = c.platform_id) AND (p.active = true))
  ORDER BY (p.id <> c.price_id);


--
-- TOC entry 244 (class 1259 OID 61129)
-- Name: view_transactions_all; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_transactions_all WITH (security_barrier='false') AS
 SELECT t.payment_date,
    t.start_date,
    t.end_date,
    i.name AS inventory,
    p.shortname AS platform,
    o.shortname AS operator,
    bs.name AS bus_size,
    pr.name AS print_stage,
    c.name AS campaign,
    v.name AS vendor,
    t.quantity,
    ps.price,
    ps.operator_fee,
    ps.lamata_fee,
    ps.agency_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ts.name AS transaction_status,
    t.id AS transaction_id,
    t.status_id,
    c.vendor_id,
    ps.inventory_id,
    ps.platform_id,
    t.operator_id,
    ps.bus_size_id
   FROM public.main_campaigns c,
    public.main_transactions t,
    public.z_price_settings ps,
    public.y_inventory i,
    public.y_platforms p,
    public.y_operators o,
    public.x_bus_sizes bs,
    public.x_print_stage pr,
    public.y_vendors v,
    public.x_transaction_status ts
  WHERE ((c.id = t.campaign_id) AND (t.price_id = ps.id) AND (ps.inventory_id = i.id) AND (ps.platform_id = p.id) AND (ps.bus_size_id = bs.id) AND (ps.print_stage_id = pr.id) AND (t.operator_id = o.id) AND (c.vendor_id = v.id) AND (t.status_id = ts.id))
  ORDER BY t.id DESC;


--
-- TOC entry 245 (class 1259 OID 61134)
-- Name: w_vendors_operators; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.w_vendors_operators (
    id integer NOT NULL,
    vendor_id integer,
    operator_id integer
);


--
-- TOC entry 246 (class 1259 OID 61137)
-- Name: view_vendors_operators; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_vendors_operators AS
 SELECT u.vendor_id,
    vo.operator_id,
    v.name
   FROM public.main_users u,
    public.w_vendors_operators vo,
    public.y_operators o,
    public.y_vendors v
  WHERE ((vo.vendor_id = u.vendor_id) AND (vo.vendor_id = v.id) AND (vo.operator_id = o.id))
  GROUP BY u.vendor_id, vo.operator_id, v.name;


--
-- TOC entry 247 (class 1259 OID 61141)
-- Name: view_transactions_per_operator; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_transactions_per_operator AS
 SELECT t.transaction_id,
    t.campaign,
    t.payment_date,
    t.inventory,
    t.bus_size,
    t.print_stage,
    t.quantity,
    t.operator_fee,
    t.start_date,
    t.end_date,
    t.vendor,
    t.operator,
    t.platform,
    t.transaction_status,
    t.status_id,
    t.vendor_id,
    t.inventory_id,
    t.platform_id,
    t.operator_id,
    t.bus_size_id,
    v.vendor_id AS vendor_search_id,
    v.name AS vendor_search_name
   FROM public.view_transactions_all t,
    public.view_vendors_operators v
  WHERE (t.operator_id = v.operator_id);


--
-- TOC entry 248 (class 1259 OID 61146)
-- Name: view_transactions_per_platform; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view_transactions_per_platform AS
 SELECT t.transaction_id,
    t.campaign,
    t.payment_date,
    t.inventory,
    t.bus_size,
    t.print_stage,
    t.quantity,
    t.lamata_fee,
    t.start_date,
    t.end_date,
    t.vendor,
    t.operator,
    t.platform,
    t.transaction_status,
    t.status_id,
    t.vendor_id,
    t.inventory_id,
    t.platform_id,
    t.operator_id,
    t.bus_size_id,
    v.vendor_id AS vendor_search_id,
    v.name AS vendor_search_name
   FROM public.view_transactions_all t,
    public.view_vendors_operators v
  WHERE ((t.operator_id = v.operator_id) AND (v.vendor_id = 18));


--
-- TOC entry 249 (class 1259 OID 61151)
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.w_vendors_operators_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3243 (class 0 OID 0)
-- Dependencies: 249
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.w_vendors_operators_id_seq OWNED BY public.w_vendors_operators.id;


--
-- TOC entry 250 (class 1259 OID 61153)
-- Name: x_bus_depot_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_bus_depot_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3244 (class 0 OID 0)
-- Dependencies: 250
-- Name: x_bus_depot_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_bus_depot_id_seq OWNED BY public.x_bus_depot.id;


--
-- TOC entry 251 (class 1259 OID 61155)
-- Name: x_bus_sizes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_bus_sizes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3245 (class 0 OID 0)
-- Dependencies: 251
-- Name: x_bus_sizes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_bus_sizes_id_seq OWNED BY public.x_bus_sizes.id;


--
-- TOC entry 252 (class 1259 OID 61157)
-- Name: x_bus_status_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_bus_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3246 (class 0 OID 0)
-- Dependencies: 252
-- Name: x_bus_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_bus_status_id_seq OWNED BY public.x_bus_status.id;


--
-- TOC entry 253 (class 1259 OID 61159)
-- Name: x_payment_status_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_payment_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3247 (class 0 OID 0)
-- Dependencies: 253
-- Name: x_payment_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_payment_status_id_seq OWNED BY public.x_payment_status.id;


--
-- TOC entry 254 (class 1259 OID 61161)
-- Name: x_print_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_print_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3248 (class 0 OID 0)
-- Dependencies: 254
-- Name: x_print_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_print_stage_id_seq OWNED BY public.x_print_stage.id;


--
-- TOC entry 255 (class 1259 OID 61163)
-- Name: x_print_status_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_print_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3249 (class 0 OID 0)
-- Dependencies: 255
-- Name: x_print_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_print_status_id_seq OWNED BY public.x_print_status.id;


--
-- TOC entry 256 (class 1259 OID 61165)
-- Name: x_renewal_stage; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_renewal_stage (
    id integer NOT NULL,
    name text NOT NULL
);


--
-- TOC entry 257 (class 1259 OID 61171)
-- Name: x_renewal_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_renewal_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3250 (class 0 OID 0)
-- Dependencies: 257
-- Name: x_renewal_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_renewal_stage_id_seq OWNED BY public.x_renewal_stage.id;


--
-- TOC entry 258 (class 1259 OID 61173)
-- Name: x_report_types; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.x_report_types (
    id integer NOT NULL,
    name text
);


--
-- TOC entry 259 (class 1259 OID 61179)
-- Name: x_transaction_status_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_transaction_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3251 (class 0 OID 0)
-- Dependencies: 259
-- Name: x_transaction_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_transaction_status_id_seq OWNED BY public.x_transaction_status.id;


--
-- TOC entry 260 (class 1259 OID 61181)
-- Name: x_user_types_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.x_user_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3252 (class 0 OID 0)
-- Dependencies: 260
-- Name: x_user_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.x_user_types_id_seq OWNED BY public.x_user_types.id;


--
-- TOC entry 261 (class 1259 OID 61183)
-- Name: y_inventory_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.y_inventory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3253 (class 0 OID 0)
-- Dependencies: 261
-- Name: y_inventory_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.y_inventory_id_seq OWNED BY public.y_inventory.id;


--
-- TOC entry 262 (class 1259 OID 61185)
-- Name: y_operators_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.y_operators_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3254 (class 0 OID 0)
-- Dependencies: 262
-- Name: y_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.y_operators_id_seq OWNED BY public.y_operators.id;


--
-- TOC entry 263 (class 1259 OID 61187)
-- Name: y_platforms_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.y_platforms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3255 (class 0 OID 0)
-- Dependencies: 263
-- Name: y_platforms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.y_platforms_id_seq OWNED BY public.y_platforms.id;


--
-- TOC entry 264 (class 1259 OID 61189)
-- Name: y_printers; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.y_printers (
    id integer NOT NULL,
    name text,
    passcode character varying(5),
    email text
);


--
-- TOC entry 265 (class 1259 OID 61195)
-- Name: y_printers_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.y_printers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3256 (class 0 OID 0)
-- Dependencies: 265
-- Name: y_printers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.y_printers_id_seq OWNED BY public.y_printers.id;


--
-- TOC entry 266 (class 1259 OID 61197)
-- Name: y_vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.y_vendors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3257 (class 0 OID 0)
-- Dependencies: 266
-- Name: y_vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.y_vendors_id_seq OWNED BY public.y_vendors.id;


--
-- TOC entry 267 (class 1259 OID 61199)
-- Name: z_core_settings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.z_core_settings (
    id integer NOT NULL,
    name character varying NOT NULL,
    value character varying NOT NULL
);


--
-- TOC entry 268 (class 1259 OID 61205)
-- Name: z_core_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.z_core_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3258 (class 0 OID 0)
-- Dependencies: 268
-- Name: z_core_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.z_core_settings_id_seq OWNED BY public.z_core_settings.id;


--
-- TOC entry 269 (class 1259 OID 61207)
-- Name: z_email_settings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.z_email_settings (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    description text,
    to_value text,
    cc_value text,
    bcc_value text
);


--
-- TOC entry 270 (class 1259 OID 61213)
-- Name: z_email_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.z_email_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3259 (class 0 OID 0)
-- Dependencies: 270
-- Name: z_email_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.z_email_settings_id_seq OWNED BY public.z_email_settings.id;


--
-- TOC entry 271 (class 1259 OID 61215)
-- Name: z_price_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.z_price_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3260 (class 0 OID 0)
-- Dependencies: 271
-- Name: z_price_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.z_price_settings_id_seq OWNED BY public.z_price_settings.id;


--
-- TOC entry 2955 (class 2604 OID 61226)
-- Name: main_buses id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses ALTER COLUMN id SET DEFAULT nextval('public.main_buses_id_seq'::regclass);


--
-- TOC entry 2959 (class 2604 OID 61227)
-- Name: main_campaigns id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns ALTER COLUMN id SET DEFAULT nextval('public.main_campaigns_id_seq'::regclass);


--
-- TOC entry 2963 (class 2604 OID 61228)
-- Name: main_print_orders id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_print_orders ALTER COLUMN id SET DEFAULT nextval('public.main_print_orders_id_seq'::regclass);


--
-- TOC entry 2965 (class 2604 OID 61229)
-- Name: main_reports id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_reports ALTER COLUMN id SET DEFAULT nextval('public.main_reports_id_seq'::regclass);


--
-- TOC entry 2971 (class 2604 OID 61230)
-- Name: main_transactions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_transactions ALTER COLUMN id SET DEFAULT nextval('public.main_transactions_id_seq'::regclass);


--
-- TOC entry 2973 (class 2604 OID 61231)
-- Name: main_users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_users ALTER COLUMN id SET DEFAULT nextval('public.main_users_id_seq'::regclass);


--
-- TOC entry 2976 (class 2604 OID 61237)
-- Name: sub_media_allocation id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_media_allocation ALTER COLUMN id SET DEFAULT nextval('public.sub_media_allocation_id_seq'::regclass);


--
-- TOC entry 2977 (class 2604 OID 61238)
-- Name: sub_renewal_requests id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_renewal_requests ALTER COLUMN id SET DEFAULT nextval('public.sub_renewal_requests_id_seq'::regclass);


--
-- TOC entry 2980 (class 2604 OID 61239)
-- Name: sub_transaction_details id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_transaction_details ALTER COLUMN id SET DEFAULT nextval('public.sub_transaction_details_id_seq'::regclass);


--
-- TOC entry 2996 (class 2604 OID 61243)
-- Name: w_vendors_operators id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.w_vendors_operators ALTER COLUMN id SET DEFAULT nextval('public.w_vendors_operators_id_seq'::regclass);


--
-- TOC entry 2981 (class 2604 OID 61244)
-- Name: x_bus_depot id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_depot ALTER COLUMN id SET DEFAULT nextval('public.x_bus_depot_id_seq'::regclass);


--
-- TOC entry 2982 (class 2604 OID 61245)
-- Name: x_bus_sizes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_sizes ALTER COLUMN id SET DEFAULT nextval('public.x_bus_sizes_id_seq'::regclass);


--
-- TOC entry 2983 (class 2604 OID 61246)
-- Name: x_bus_status id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_status ALTER COLUMN id SET DEFAULT nextval('public.x_bus_status_id_seq'::regclass);


--
-- TOC entry 2987 (class 2604 OID 61247)
-- Name: x_payment_status id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_payment_status ALTER COLUMN id SET DEFAULT nextval('public.x_payment_status_id_seq'::regclass);


--
-- TOC entry 2988 (class 2604 OID 61248)
-- Name: x_print_stage id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_print_stage ALTER COLUMN id SET DEFAULT nextval('public.x_print_stage_id_seq'::regclass);


--
-- TOC entry 2995 (class 2604 OID 61249)
-- Name: x_print_status id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_print_status ALTER COLUMN id SET DEFAULT nextval('public.x_print_status_id_seq'::regclass);


--
-- TOC entry 2997 (class 2604 OID 61250)
-- Name: x_renewal_stage id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_renewal_stage ALTER COLUMN id SET DEFAULT nextval('public.x_renewal_stage_id_seq'::regclass);


--
-- TOC entry 2989 (class 2604 OID 61251)
-- Name: x_transaction_status id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_transaction_status ALTER COLUMN id SET DEFAULT nextval('public.x_transaction_status_id_seq'::regclass);


--
-- TOC entry 2994 (class 2604 OID 61252)
-- Name: x_user_types id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_user_types ALTER COLUMN id SET DEFAULT nextval('public.x_user_types_id_seq'::regclass);


--
-- TOC entry 2990 (class 2604 OID 61253)
-- Name: y_inventory id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_inventory ALTER COLUMN id SET DEFAULT nextval('public.y_inventory_id_seq'::regclass);


--
-- TOC entry 2984 (class 2604 OID 61254)
-- Name: y_operators id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_operators ALTER COLUMN id SET DEFAULT nextval('public.y_operators_id_seq'::regclass);


--
-- TOC entry 2985 (class 2604 OID 61255)
-- Name: y_platforms id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_platforms ALTER COLUMN id SET DEFAULT nextval('public.y_platforms_id_seq'::regclass);


--
-- TOC entry 2998 (class 2604 OID 61256)
-- Name: y_printers id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_printers ALTER COLUMN id SET DEFAULT nextval('public.y_printers_id_seq'::regclass);


--
-- TOC entry 2986 (class 2604 OID 61257)
-- Name: y_vendors id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_vendors ALTER COLUMN id SET DEFAULT nextval('public.y_vendors_id_seq'::regclass);


--
-- TOC entry 2999 (class 2604 OID 61258)
-- Name: z_core_settings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_core_settings ALTER COLUMN id SET DEFAULT nextval('public.z_core_settings_id_seq'::regclass);


--
-- TOC entry 3000 (class 2604 OID 61259)
-- Name: z_email_settings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_email_settings ALTER COLUMN id SET DEFAULT nextval('public.z_email_settings_id_seq'::regclass);


--
-- TOC entry 2993 (class 2604 OID 61260)
-- Name: z_price_settings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_price_settings ALTER COLUMN id SET DEFAULT nextval('public.z_price_settings_id_seq'::regclass);


--
-- TOC entry 3017 (class 2606 OID 61262)
-- Name: sub_media_allocation allocation_bus_campaign_uk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_campaign_uk UNIQUE (bus_id, campaign_id);


--
-- TOC entry 3003 (class 2606 OID 61290)
-- Name: main_buses main_buses_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_id_pk PRIMARY KEY (id);


--
-- TOC entry 3005 (class 2606 OID 61292)
-- Name: main_buses main_buses_number_uk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_number_uk UNIQUE (number);


--
-- TOC entry 3007 (class 2606 OID 61294)
-- Name: main_campaigns main_campaigns_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT main_campaigns_id_pk PRIMARY KEY (id);


--
-- TOC entry 3011 (class 2606 OID 61296)
-- Name: main_reports main_exterior_reports_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT main_exterior_reports_id_pk PRIMARY KEY (id);


--
-- TOC entry 3009 (class 2606 OID 61298)
-- Name: main_print_orders main_print_orders_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_print_orders
    ADD CONSTRAINT main_print_orders_pk PRIMARY KEY (id);


--
-- TOC entry 3013 (class 2606 OID 61300)
-- Name: main_transactions main_transactions_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_transactions
    ADD CONSTRAINT main_transactions_id_pk PRIMARY KEY (id);


--
-- TOC entry 3015 (class 2606 OID 61302)
-- Name: main_users main_users_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_users
    ADD CONSTRAINT main_users_id_pk PRIMARY KEY (id);


--
-- TOC entry 3019 (class 2606 OID 61320)
-- Name: sub_media_allocation sub_media_allocation_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT sub_media_allocation_id_pk PRIMARY KEY (id);


--
-- TOC entry 3021 (class 2606 OID 61322)
-- Name: sub_renewal_requests sub_renewal_requests_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_renewal_requests
    ADD CONSTRAINT sub_renewal_requests_id_pk PRIMARY KEY (id);


--
-- TOC entry 3023 (class 2606 OID 61324)
-- Name: sub_transaction_details sub_transaction_details_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_transaction_details
    ADD CONSTRAINT sub_transaction_details_id_pk PRIMARY KEY (id);


--
-- TOC entry 3059 (class 2606 OID 61340)
-- Name: w_vendors_operators w_vendors_operators_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.w_vendors_operators
    ADD CONSTRAINT w_vendors_operators_id_pk PRIMARY KEY (id);


--
-- TOC entry 3025 (class 2606 OID 61342)
-- Name: x_bus_depot x_bus_depot_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT x_bus_depot_pk PRIMARY KEY (id);


--
-- TOC entry 3027 (class 2606 OID 61344)
-- Name: x_bus_depot x_bus_depot_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT x_bus_depot_unique UNIQUE (name);


--
-- TOC entry 3029 (class 2606 OID 61346)
-- Name: x_bus_sizes x_bus_sizes_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_sizes
    ADD CONSTRAINT x_bus_sizes_id_pk PRIMARY KEY (id);


--
-- TOC entry 3031 (class 2606 OID 61348)
-- Name: x_bus_status x_bus_status_name_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT x_bus_status_name_key UNIQUE (name);


--
-- TOC entry 3033 (class 2606 OID 61350)
-- Name: x_bus_status x_bus_status_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT x_bus_status_pk PRIMARY KEY (id);


--
-- TOC entry 3047 (class 2606 OID 61352)
-- Name: x_transaction_status x_campaign_status_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_transaction_status
    ADD CONSTRAINT x_campaign_status_pk PRIMARY KEY (id);


--
-- TOC entry 3041 (class 2606 OID 61354)
-- Name: x_payment_status x_payment_status_name_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT x_payment_status_name_key UNIQUE (name);


--
-- TOC entry 3043 (class 2606 OID 61356)
-- Name: x_payment_status x_payment_status_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT x_payment_status_pk PRIMARY KEY (id);


--
-- TOC entry 3045 (class 2606 OID 61358)
-- Name: x_print_stage x_print_stage_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_print_stage
    ADD CONSTRAINT x_print_stage_id_pk PRIMARY KEY (id);


--
-- TOC entry 3055 (class 2606 OID 61360)
-- Name: x_print_status x_print_status_name_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT x_print_status_name_key UNIQUE (name);


--
-- TOC entry 3057 (class 2606 OID 61362)
-- Name: x_print_status x_print_status_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT x_print_status_pk PRIMARY KEY (id);


--
-- TOC entry 3061 (class 2606 OID 61364)
-- Name: x_renewal_stage x_renewal_stage_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_renewal_stage
    ADD CONSTRAINT x_renewal_stage_pkey PRIMARY KEY (id);


--
-- TOC entry 3063 (class 2606 OID 61366)
-- Name: x_report_types x_report_types_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_report_types
    ADD CONSTRAINT x_report_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3053 (class 2606 OID 61368)
-- Name: x_user_types x_user_types_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.x_user_types
    ADD CONSTRAINT x_user_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3049 (class 2606 OID 61370)
-- Name: y_inventory y_inventory_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_inventory
    ADD CONSTRAINT y_inventory_id_pk PRIMARY KEY (id);


--
-- TOC entry 3035 (class 2606 OID 61372)
-- Name: y_operators y_operator_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT y_operator_id_pk PRIMARY KEY (id);


--
-- TOC entry 3037 (class 2606 OID 61374)
-- Name: y_platforms y_platform_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_platforms
    ADD CONSTRAINT y_platform_id_pk PRIMARY KEY (id);


--
-- TOC entry 3065 (class 2606 OID 61376)
-- Name: y_printers y_printers_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_printers
    ADD CONSTRAINT y_printers_pkey PRIMARY KEY (id);


--
-- TOC entry 3039 (class 2606 OID 61378)
-- Name: y_vendors y_vendors_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_vendors
    ADD CONSTRAINT y_vendors_pkey PRIMARY KEY (id);


--
-- TOC entry 3067 (class 2606 OID 61380)
-- Name: z_core_settings z_core_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_core_settings
    ADD CONSTRAINT z_core_settings_pkey PRIMARY KEY (id);


--
-- TOC entry 3069 (class 2606 OID 61382)
-- Name: z_email_settings z_email_settings_name_uk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT z_email_settings_name_uk UNIQUE (name);


--
-- TOC entry 3071 (class 2606 OID 61384)
-- Name: z_email_settings z_email_settings_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT z_email_settings_pk PRIMARY KEY (id);


--
-- TOC entry 3051 (class 2606 OID 61386)
-- Name: z_price_settings z_pricing_id_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.z_price_settings
    ADD CONSTRAINT z_pricing_id_pk PRIMARY KEY (id);


--
-- TOC entry 3001 (class 1259 OID 61387)
-- Name: fki_main_buses_depot_fk; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX fki_main_buses_depot_fk ON public.main_buses USING btree (bus_depot_id);


--
-- TOC entry 3217 (class 2618 OID 61051)
-- Name: view_campaign_status _RETURN; Type: RULE; Schema: public; Owner: -
--

CREATE OR REPLACE VIEW public.view_campaign_status AS
 SELECT v.id,
    v.name,
    v.pending,
    v.approved,
    v.denied,
        CASE
            WHEN ((v.pending > 0) OR ((v.denied + v.approved) = 0)) THEN 'PENDING'::text
            ELSE
            CASE
                WHEN ((v.denied > 0) AND (v.approved = 0)) THEN 'DENIED'::text
                WHEN ((v.denied = 0) AND (v.approved > 0)) THEN 'APPROVED'::text
                ELSE 'APPROVED'::text
            END
        END AS status,
    array_to_string(ARRAY[v.approved, v.pending, v.denied], ','::text, '*'::text) AS status_matrix,
    (((((('{"approved":'::text || v.approved) || ',"pending":'::text) || v.pending) || ',"denied":'::text) || v.denied) || '}'::text) AS status_json
   FROM ( SELECT c.id,
            c.name,
            count(
                CASE
                    WHEN (t.status_id = ANY (ARRAY[1, 4])) THEN 1
                    ELSE NULL::integer
                END) AS pending,
            count(
                CASE
                    WHEN (t.status_id = ANY (ARRAY[2, 5])) THEN 1
                    ELSE NULL::integer
                END) AS approved,
            count(
                CASE
                    WHEN (t.status_id = 3) THEN 1
                    ELSE NULL::integer
                END) AS denied
           FROM (public.main_campaigns c
             LEFT JOIN public.main_transactions t ON ((c.id = t.campaign_id)))
          GROUP BY c.id) v
  ORDER BY v.pending DESC;


--
-- TOC entry 3084 (class 2606 OID 61389)
-- Name: sub_media_allocation allocation_bus_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_id_fk FOREIGN KEY (bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3085 (class 2606 OID 61394)
-- Name: sub_media_allocation allocation_campaign_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_campaign_id_fk FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3078 (class 2606 OID 61399)
-- Name: main_campaigns bus_size_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT bus_size_id_fk FOREIGN KEY (bus_size_id) REFERENCES public.x_bus_sizes(id);


--
-- TOC entry 3082 (class 2606 OID 61459)
-- Name: main_reports exterior_reports_fk1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk1 FOREIGN KEY (ref_bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3083 (class 2606 OID 61469)
-- Name: main_reports exterior_reports_fk2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk2 FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3079 (class 2606 OID 61474)
-- Name: main_campaigns inventory_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT inventory_id_fk FOREIGN KEY (inventory_id) REFERENCES public.y_inventory(id);


--
-- TOC entry 3072 (class 2606 OID 61479)
-- Name: main_buses main_buses_depot_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_depot_fk FOREIGN KEY (bus_depot_id) REFERENCES public.x_bus_depot(id);


--
-- TOC entry 3073 (class 2606 OID 61484)
-- Name: main_buses main_buses_fk0; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk0 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3074 (class 2606 OID 61489)
-- Name: main_buses main_buses_fk1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk1 FOREIGN KEY (exterior_campaign_id) REFERENCES public.main_campaigns(id) ON DELETE SET NULL;


--
-- TOC entry 3075 (class 2606 OID 61494)
-- Name: main_buses main_buses_fk2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk2 FOREIGN KEY (interior_campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3076 (class 2606 OID 61499)
-- Name: main_buses main_buses_fk3; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk3 FOREIGN KEY (bus_status_id) REFERENCES public.x_bus_status(id);


--
-- TOC entry 3077 (class 2606 OID 61504)
-- Name: main_buses main_buses_fk4; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk4 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3086 (class 2606 OID 61509)
-- Name: y_operators operator_platorm_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT operator_platorm_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3080 (class 2606 OID 61514)
-- Name: main_campaigns platform_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT platform_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3081 (class 2606 OID 61519)
-- Name: main_campaigns pricing_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT pricing_id_fk FOREIGN KEY (price_id) REFERENCES public.z_price_settings(id);


-- Completed on 2020-12-09 12:13:58

--
-- PostgreSQL database dump complete
--

