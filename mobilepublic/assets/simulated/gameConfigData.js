var gameConfigData = {
    "gameId": "1",
    "gameSeriesId": "1",
    "gameNameEn": "CQSSC",
    "gameNameCn": "重庆时时彩",
    "wayGroups": [
        {
            "id": "2",
            "pid": 0,
            "name_cn": "五星",
            "name_en": "wuxing",
            "children": [
                {
                    "id": "4",
                    "pid": "2",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "68",
                            "pid": "4",
                            "series_way_id": "68",
                            "relation_series_way_ids": null,
                            "name_cn": "直选复式",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "从个、十、百、千、万位各选一个号码组成一注",
                            "bonus_note": "从万位、千位、百位、十位、个位中各选择一个号码组成一注，所选号码与开奖号码全部相同，且顺序一致，即为中奖。",
                            "basic_methods": "16"
                        },
                        {
                            "id": "7",
                            "pid": "4",
                            "series_way_id": "7",
                            "relation_series_way_ids": null,
                            "name_cn": "直选单式",
                            "name_en": "danshi",
                            "price": "2",
                            "bet_note": "从个、十、百、千、万位各选一个号码组成一注",
                            "bonus_note": "从万位、千位、百位、十位、个位中各选择一个号码组成一注，所选号码与开奖号码全部相同，且顺序一致，即为中奖。",
                            "basic_methods": "16"
                        },
                        {
                            "id": "15",
                            "pid": "4",
                            "series_way_id": "15",
                            "relation_series_way_ids": null,
                            "name_cn": "直选组合",
                            "name_en": "zuhe",
                            "price": "2",
                            "bet_note": "从个、十、百、千、万位各选一个号码组成五注",
                            "bonus_note": "从万位、千位、百位、十位、个位中各选一个号码组成1-5星的组合，共五注，所选号码的个位与开奖号码全部相同，则中1个5等奖；所选号码的个位、十位与开奖号码相同，则中1个5等奖以及1个4等奖，依此类推，最高可中5个奖。",
                            "basic_methods": "11,16,1,5,6"
                        }
                    ]
                },
                {
                    "id": "5",
                    "pid": "2",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "32",
                            "pid": "5",
                            "series_way_id": "32",
                            "relation_series_way_ids": null,
                            "name_cn": "组选120",
                            "name_en": "zuxuan120",
                            "price": "2",
                            "bet_note": "从0-9中选择5个号码组成一注",
                            "bonus_note": "从0-9中任意选择5个号码组成一注，所选号码与开奖号码的万位、千位、百位、十位、个位相同，顺序不限，即为中奖。",
                            "basic_methods": "22"
                        },
                        {
                            "id": "31",
                            "pid": "5",
                            "series_way_id": "31",
                            "relation_series_way_ids": null,
                            "name_cn": "组选60",
                            "name_en": "zuxuan60",
                            "price": "2",
                            "bet_note": "从“二重号”选择一个号码，“单号”中选择三个号码组成一注",
                            "bonus_note": "选择1个“二重号”和3个单号号码组成一注，所选的单号号码与开奖号码相同，且所选二重号码在开奖号码中出现了2次，即为中奖。",
                            "basic_methods": "21"
                        },
                        {
                            "id": "30",
                            "pid": "5",
                            "series_way_id": "30",
                            "relation_series_way_ids": null,
                            "name_cn": "组选30",
                            "name_en": "zuxuan30",
                            "price": "2",
                            "bet_note": "从“二重号”选择两个号码，“单号”中选择一个号码组成一注",
                            "bonus_note": "选择2个二重号和1个单号号码组成一注，所选的单号号码与开奖号码相同，且所选的2个二重号码分别在开奖号码中出现了2次，即为中奖",
                            "basic_methods": "20"
                        },
                        {
                            "id": "29",
                            "pid": "5",
                            "series_way_id": "29",
                            "relation_series_way_ids": null,
                            "name_cn": "组选20",
                            "name_en": "zuxuan20",
                            "price": "2",
                            "bet_note": "从“三重号”选择一个号码，“单号”中选择两个号码组成一注",
                            "bonus_note": "选择1个三重号码和2个单号号码组成一注，所选的单号号码与开奖号码相同，且所选三重号码在开奖号码中出现了3次，即为中奖。",
                            "basic_methods": "19"
                        },
                        {
                            "id": "28",
                            "pid": "5",
                            "series_way_id": "28",
                            "relation_series_way_ids": null,
                            "name_cn": "组选10",
                            "name_en": "zuxuan10",
                            "price": "2",
                            "bet_note": "从“三重号”选择一个号码，“二重号”中选择一个号码组成一注",
                            "bonus_note": "选择1个三重号码和1个二重号码，所选三重号码在开奖号码中出现3次，并且所选二重号码在开奖号码中出现了2次，即为中奖。",
                            "basic_methods": "18"
                        },
                        {
                            "id": "27",
                            "pid": "5",
                            "series_way_id": "27",
                            "relation_series_way_ids": null,
                            "name_cn": "组选5",
                            "name_en": "zuxuan5",
                            "price": "2",
                            "bet_note": "从“四重号”选择一个号码，“单号”中选择一个号码组成一注",
                            "bonus_note": "选择1个四重号码和1个单号号码组成一注，所选的单号号码与开奖号码相同，且所选四重号码在开奖号码中出现了4次，即为中奖。",
                            "basic_methods": "17"
                        }
                    ]
                },
                {
                    "id": "108",
                    "pid": "2",
                    "name_cn": "其他",
                    "name_en": "qita",
                    "children": [
                        {
                            "id": "185",
                            "pid": "108",
                            "series_way_id": "185",
                            "relation_series_way_ids": null,
                            "name_cn": "龙虎和",
                            "name_en": "longhuhe",
                            "price": "2",
                            "bet_note": "选择一个或多个号码形态",
                            "bonus_note": "龙：开奖第一球（万位）的号码 大于 第五球（个位）的号码。\r\n虎：开奖第一球（万位）的号码 小于 第五球（个位）的号码。\r\n和：开奖第一球（万位）的号码 等于 第五球（个位）的号码。",
                            "basic_methods": "88,87"
                        },
                        {
                            "id": "184",
                            "pid": "108",
                            "series_way_id": "184",
                            "relation_series_way_ids": null,
                            "name_cn": "总和大小单双",
                            "name_en": "sumdxds",
                            "price": "2",
                            "bet_note": "选择一个或多个号码形态",
                            "bonus_note": "大小：根据相应单项投注的第一球 ~ 第五球开出的球号数字总和值大于或等于 23 为总和大，小于或等于 22 为总和小。\r\n单双：根据相应单项投注的第一球 ~ 第五球开出的球号数字总和值是双数为总和双，数字总和值是单数为总和单。",
                            "basic_methods": "89"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "3",
            "pid": 0,
            "name_cn": "四星",
            "name_en": "sixing",
            "children": [
                {
                    "id": "6",
                    "pid": "3",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "67",
                            "pid": "6",
                            "series_way_id": "67",
                            "relation_series_way_ids": null,
                            "name_cn": "直选复式",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "从个、十、百、千位各选一个号码组成一注",
                            "bonus_note": "从千位、百位、十位、个位中各选择一个号码组成一注，所选号码与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "11"
                        },
                        {
                            "id": "6",
                            "pid": "6",
                            "series_way_id": "6",
                            "relation_series_way_ids": null,
                            "name_cn": "直选单式",
                            "name_en": "danshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个四位数号码组成一注",
                            "bonus_note": "手动输入一个4位数号码组成一注，所选号码的千位、百位、十位、个位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "11"
                        },
                        {
                            "id": "79",
                            "pid": "6",
                            "series_way_id": "79",
                            "relation_series_way_ids": null,
                            "name_cn": "直选组合",
                            "name_en": "zuhe",
                            "price": "2",
                            "bet_note": "从个、十、百、千位各选一个号码组成四注",
                            "bonus_note": "从千位、百位、十位、个位中至少各选一个号码组成1-4星的组合，共四注，所选号码的个位与开奖号码相同，则中1个4等奖；所选号码的个位、十位与开奖号码相同，则中1个4等奖以及1个3等奖，依此类推，最高可中4个奖。",
                            "basic_methods": "11,1,5,6"
                        }
                    ]
                },
                {
                    "id": "7",
                    "pid": "3",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "26",
                            "pid": "7",
                            "series_way_id": "26",
                            "relation_series_way_ids": null,
                            "name_cn": "组选24",
                            "name_en": "zuxuan24",
                            "price": "2",
                            "bet_note": "从0-9中选择4个号码组成一注",
                            "bonus_note": "从0-9中任意选择4个号码组成一注，所选号码与开奖号码的千位、百位、十位、个位相同，且顺序不限，即为中奖",
                            "basic_methods": "15"
                        },
                        {
                            "id": "25",
                            "pid": "7",
                            "series_way_id": "25",
                            "relation_series_way_ids": null,
                            "name_cn": "组选12",
                            "name_en": "zuxuan12",
                            "price": "2",
                            "bet_note": "从“二重号”选择一个号码，“单号”中选择两个号码组成一注",
                            "bonus_note": "选择1个二重号码和2个单号号码组成一注，所选单号号码与开奖号码相同，且所选二重号码在开奖号码中出现了2次，即为中奖。",
                            "basic_methods": "14"
                        },
                        {
                            "id": "24",
                            "pid": "7",
                            "series_way_id": "24",
                            "relation_series_way_ids": null,
                            "name_cn": "组选6",
                            "name_en": "zuxuan6",
                            "price": "2",
                            "bet_note": "从“二重号”选择两个号码组成一注",
                            "bonus_note": "选择2个二重号码组成一注，所选的2个二重号码在开奖号码中分别出现了2次，即为中奖。",
                            "basic_methods": "13"
                        },
                        {
                            "id": "23",
                            "pid": "7",
                            "series_way_id": "23",
                            "relation_series_way_ids": null,
                            "name_cn": "组选4",
                            "name_en": "zuxuan4",
                            "price": "2",
                            "bet_note": "从“三重号”选择一个号码，“单号”中选择两个号码组成一注",
                            "bonus_note": "选择1个三重号码和1个单号号码组成一注，所选单号号码与开奖号码相同，且所选三重号码在开奖号码中出现了3次，即为中奖。",
                            "basic_methods": "12"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "8",
            "pid": 0,
            "name_cn": "前三",
            "name_en": "qiansan",
            "children": [
                {
                    "id": "10",
                    "pid": "8",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "65",
                            "pid": "10",
                            "series_way_id": "65",
                            "relation_series_way_ids": null,
                            "name_cn": "直选复式",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "从万、千、百位各选一个号码组成一注",
                            "bonus_note": "从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码的前3位相同，且顺序一致，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "1",
                            "pid": "10",
                            "series_way_id": "1",
                            "relation_series_way_ids": null,
                            "name_cn": "直选单式",
                            "name_en": "danshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码组成一注",
                            "bonus_note": "手动输入一个3位数号码组成一注，所选号码的万位、千位、百位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "71",
                            "pid": "10",
                            "series_way_id": "71",
                            "relation_series_way_ids": null,
                            "name_cn": "直选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从0-27中任意选择1个或1个以上号码。",
                            "bonus_note": "所选数值等于开奖号码的万位、千位、百位三个数字相加之和，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "60",
                            "pid": "10",
                            "series_way_id": "60",
                            "relation_series_way_ids": null,
                            "name_cn": "直选跨度",
                            "name_en": "kuadu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码的前3位最大与最小数字相减之差，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "14",
                            "pid": "10",
                            "series_way_id": "14",
                            "relation_series_way_ids": null,
                            "name_cn": "直选组合",
                            "name_en": "zuhe",
                            "price": "2",
                            "bet_note": "从万、千、百位各选一个号码组成三注",
                            "bonus_note": "从万位、千位、百位中至少各选择一个号码组成1-3星的组合共三注，当百位号码与开奖号码相同，则中1个3等奖；如果百位与千位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。",
                            "basic_methods": "1,6,5"
                        }
                    ]
                },
                {
                    "id": "11",
                    "pid": "8",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "16",
                            "pid": "11",
                            "series_way_id": "16",
                            "relation_series_way_ids": null,
                            "name_cn": "组三",
                            "name_en": "zusan",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个或2个以上号码",
                            "bonus_note": "从0-9中选择2个数字组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。",
                            "basic_methods": "2"
                        },
                        {
                            "id": "17",
                            "pid": "11",
                            "series_way_id": "17",
                            "relation_series_way_ids": null,
                            "name_cn": "组六",
                            "name_en": "zuliu",
                            "price": "2",
                            "bet_note": "从0-9中任意选择3个或3个以上号码",
                            "bonus_note": "从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。",
                            "basic_methods": "3"
                        },
                        {
                            "id": "13",
                            "pid": "11",
                            "series_way_id": "13",
                            "relation_series_way_ids": null,
                            "name_cn": "混合组选",
                            "name_en": "hunhezuxuan",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码",
                            "bonus_note": "手动输入组三或组六号码，3个数字为一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "75",
                            "pid": "11",
                            "series_way_id": "75",
                            "relation_series_way_ids": null,
                            "name_cn": "组选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从1-26中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码万位、千位、百位三个数字相加之和(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "2",
                            "pid": "11",
                            "series_way_id": "2",
                            "relation_series_way_ids": null,
                            "name_cn": "组三单式",
                            "name_en": "zusandanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入 1 个三位数号码。(三个数字当中有二个数字相同)",
                            "bonus_note": "手动输入一个3位数号码组成一注(不含豹子号)，开奖号码的万位、千位、百位符合后三组三为中奖。",
                            "basic_methods": "2"
                        },
                        {
                            "id": "3",
                            "pid": "11",
                            "series_way_id": "3",
                            "relation_series_way_ids": null,
                            "name_cn": "组六单式",
                            "name_en": "zuliudanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入 1 个三位数号码。(三个数字全不相同)",
                            "bonus_note": "手动输入一个3位数号码组成一注(不含豹子号)，开奖号码的万位、千位、百位符合前三组六为中奖。",
                            "basic_methods": "3"
                        },
                        {
                            "id": "64",
                            "pid": "11",
                            "series_way_id": "64",
                            "relation_series_way_ids": null,
                            "name_cn": "包胆",
                            "name_en": "baodan",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "从0-9中任意选择1个包胆号码，开奖号码的万位、千位、百位中任意1位只要和所选包胆号码相同(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        }
                    ]
                },
                {
                    "id": "12",
                    "pid": "8",
                    "name_cn": "其它",
                    "name_en": "qita",
                    "children": [
                        {
                            "id": "33",
                            "pid": "12",
                            "series_way_id": "33",
                            "relation_series_way_ids": null,
                            "name_cn": "和值尾数",
                            "name_en": "hezhiweishu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码的万位、千位、百位三个数字相加之和的尾数，即为中奖。",
                            "basic_methods": "23"
                        },
                        {
                            "id": "48",
                            "pid": "12",
                            "series_way_id": "48",
                            "relation_series_way_ids": null,
                            "name_cn": "特殊号码",
                            "name_en": "teshuhaoma",
                            "price": "2",
                            "bet_note": "选择一个号码形态",
                            "bonus_note": "豹子：开奖号码的万位千位百位数字都相同。\r\n顺子：开奖号码的万位千位百位数字都相连，不分顺序（数字9、0、1相连）。\r\n对子：开奖号码的万位千位百位任意两位数字相同（不包括豹子）。\r\n半顺：开奖号码的万位千位百位任意两位数字相连，不分顺序（不包括顺子、对子）。\r\n杂六：不包括豹子、对子、顺子、半顺的所有开奖号码。",
                            "basic_methods": "38,39,40,90,91"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "61",
            "pid": 0,
            "name_cn": "中三",
            "name_en": "zhongsan",
            "children": [
                {
                    "id": "62",
                    "pid": "61",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "150",
                            "pid": "62",
                            "series_way_id": "150",
                            "relation_series_way_ids": null,
                            "name_cn": "直选复式",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码组成一注",
                            "bonus_note": "手动输入一个3位数号码组成一注，所选号码的千位、百位、十位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "142",
                            "pid": "62",
                            "series_way_id": "142",
                            "relation_series_way_ids": null,
                            "name_cn": "直选单式",
                            "name_en": "danshi",
                            "price": "2",
                            "bet_note": "于千、百、个位分别从0~9选择1个号码、2个号码或多个号码，只要当期开奖结果与所选的号码相同且顺序一致时，即为中奖。",
                            "bonus_note": "如选择号码千位为4、百位为3，十位为2，若当期开奖结果为x432x即中奖（x=0~9任一数）",
                            "basic_methods": "1"
                        },
                        {
                            "id": "151",
                            "pid": "62",
                            "series_way_id": "151",
                            "relation_series_way_ids": null,
                            "name_cn": "直选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从0-27中任意选择1个或1个以上号码。",
                            "bonus_note": "所选数值等于开奖号码的千位、百位、十位三个数字相加之和，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "149",
                            "pid": "62",
                            "series_way_id": "149",
                            "relation_series_way_ids": null,
                            "name_cn": "直选跨度",
                            "name_en": "kuadu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码的中间3位最大与最小数字相减之差，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "513",
                            "pid": "62",
                            "series_way_id": "513",
                            "relation_series_way_ids": null,
                            "name_cn": "直选组合",
                            "name_en": "zuhe",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "6,1,5"
                        }
                    ]
                },
                {
                    "id": "63",
                    "pid": "61",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "145",
                            "pid": "63",
                            "series_way_id": "145",
                            "relation_series_way_ids": null,
                            "name_cn": "组三",
                            "name_en": "zusan",
                            "price": "2",
                            "bet_note": "于千、百、个位自0-9选择2个或者多个号码，如果开奖号码为组三形态即为中奖。组三形态为任意一个数加一个对子。",
                            "bonus_note": "如选择号码21，若当期开奖结果为x211x、x121x、x212x皆视为中奖（x=0~9任一数）",
                            "basic_methods": "2"
                        },
                        {
                            "id": "146",
                            "pid": "63",
                            "series_way_id": "146",
                            "relation_series_way_ids": null,
                            "name_cn": "组六",
                            "name_en": "zuliu",
                            "price": "2",
                            "bet_note": "于千、百、个位自0-9选择3个或者多个号码，如果开奖号码为组六形态即为中奖。组六形态为任意三个不相同的号码。",
                            "bonus_note": "如选择号码321，若当期开奖结果为x321x、x312x、x123x、 x132x、x213x、x231x皆视为中奖（x=0~9任一数）",
                            "basic_methods": "3"
                        },
                        {
                            "id": "152",
                            "pid": "63",
                            "series_way_id": "152",
                            "relation_series_way_ids": null,
                            "name_cn": "混合组选",
                            "name_en": "hunhezuxuan",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码",
                            "bonus_note": "手动输入组三或组六号码，3个数字为一注，所选号码与开奖号码的千位、百位、十位相同，顺序不限，即为中奖",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "154",
                            "pid": "63",
                            "series_way_id": "154",
                            "relation_series_way_ids": null,
                            "name_cn": "组选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从1-26中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码千位、百位、十位三个数字相加之和(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "143",
                            "pid": "63",
                            "series_way_id": "143",
                            "relation_series_way_ids": null,
                            "name_cn": "组三单式",
                            "name_en": "zusandanshi",
                            "price": "2",
                            "bet_note": "于千、百、个位自0-9选择2个或者多个号码，如果开奖号码为组三形态即为中奖。组三形态为任意一个数加一个对子。",
                            "bonus_note": "如选择号码21，若当期开奖结果为x211x、x121x、x212x皆视为中奖（x=0~9任一数）",
                            "basic_methods": "2"
                        },
                        {
                            "id": "144",
                            "pid": "63",
                            "series_way_id": "144",
                            "relation_series_way_ids": null,
                            "name_cn": "组六单式",
                            "name_en": "zuliudanshi",
                            "price": "2",
                            "bet_note": "于千、百、个位自0-9选择3个或者多个号码，如果开奖号码为组六形态即为中奖。组六形态为任意三个不相同的号码。",
                            "bonus_note": "如选择号码321，若当期开奖结果为x321x、x312x、x123x、 x132x、x213x、x231x皆视为中奖（x=0~9任一数）",
                            "basic_methods": "3"
                        },
                        {
                            "id": "153",
                            "pid": "63",
                            "series_way_id": "153",
                            "relation_series_way_ids": null,
                            "name_cn": "包胆",
                            "name_en": "baodan",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "从0-9中任意选择1个包胆号码，开奖号码的千位、百位、十位中任意1位只要和所选包胆号码相同(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        }
                    ]
                },
                {
                    "id": "64",
                    "pid": "61",
                    "name_cn": "其它",
                    "name_en": "qita",
                    "children": [
                        {
                            "id": "156",
                            "pid": "64",
                            "series_way_id": "156",
                            "relation_series_way_ids": null,
                            "name_cn": "和值尾数",
                            "name_en": "hezhiweishu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码的千位、百位、十位三个数字相加之和的尾数，即为中奖。",
                            "basic_methods": "23"
                        },
                        {
                            "id": "155",
                            "pid": "64",
                            "series_way_id": "155",
                            "relation_series_way_ids": null,
                            "name_cn": "特殊号码",
                            "name_en": "teshuhaoma",
                            "price": "2",
                            "bet_note": "选择一个号码形态",
                            "bonus_note": "豹子：开奖号码的千位百位十位数字都相同。\r\n顺子：开奖号码的千位百位十位数字都相连，不分顺序（数字9、0、1相连）。\r\n对子：开奖号码的千位百位十位任意两位数字相同（不包括豹子）。\r\n半顺：开奖号码的千位百位十位任意两位数字相连，不分顺序（不包括顺子、对子）。\r\n杂六：不包括豹子、对子、顺子、半顺的所有开奖号码。",
                            "basic_methods": "38,39,40,90,91"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "1",
            "pid": 0,
            "name_cn": "后三",
            "name_en": "housan",
            "children": [
                {
                    "id": "13",
                    "pid": "1",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "69",
                            "pid": "13",
                            "series_way_id": "69",
                            "relation_series_way_ids": null,
                            "name_cn": "直选复式",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "从个、十、百位各选一个号码组成一注",
                            "bonus_note": "从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "8",
                            "pid": "13",
                            "series_way_id": "8",
                            "relation_series_way_ids": null,
                            "name_cn": "直选单式",
                            "name_en": "danshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码组成一注",
                            "bonus_note": "手动输入一个3位数号码组成一注，所选号码的百位、十位、个位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "73",
                            "pid": "13",
                            "series_way_id": "73",
                            "relation_series_way_ids": null,
                            "name_cn": "直选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从0-27中任意选择1个或1个以上号码",
                            "bonus_note": "所选数值等于开奖号码的百位、十位、个位三个数字相加之和，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "62",
                            "pid": "13",
                            "series_way_id": "62",
                            "relation_series_way_ids": null,
                            "name_cn": "直选跨度",
                            "name_en": "kuadu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码。",
                            "bonus_note": "所选数值等于开奖号码的后3位最大与最小数字相减之差，即为中奖。",
                            "basic_methods": "1"
                        },
                        {
                            "id": "82",
                            "pid": "13",
                            "series_way_id": "82",
                            "relation_series_way_ids": null,
                            "name_cn": "直选组合",
                            "name_en": "zuhe",
                            "price": "2",
                            "bet_note": "从个、十、百位各选一个号码组成三注",
                            "bonus_note": "从百位、十位、个位中至少各选择一个号码组成1-3星的组合共三注，当个位号码与开奖号码相同，则中1个3等奖；如果个位与十位号码与开奖号码相同，则中1个3等奖以及1个2等奖，依此类推，最高可中3个奖。",
                            "basic_methods": "1,5,6"
                        }
                    ]
                },
                {
                    "id": "9",
                    "pid": "1",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "49",
                            "pid": "9",
                            "series_way_id": "49",
                            "relation_series_way_ids": null,
                            "name_cn": "组三",
                            "name_en": "zusan",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个或2个以上号码",
                            "bonus_note": "从0-9中选择2个数字组成两注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。",
                            "basic_methods": "2"
                        },
                        {
                            "id": "50",
                            "pid": "9",
                            "series_way_id": "50",
                            "relation_series_way_ids": null,
                            "name_cn": "组六",
                            "name_en": "zuliu",
                            "price": "2",
                            "bet_note": "从0-9中任意选择3个或3个以上号码。",
                            "bonus_note": "从0-9中任意选择3个号码组成一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。",
                            "basic_methods": "3"
                        },
                        {
                            "id": "81",
                            "pid": "9",
                            "series_way_id": "81",
                            "relation_series_way_ids": null,
                            "name_cn": "混合组选",
                            "name_en": "hunhezuxuan",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个三位数号码。",
                            "bonus_note": "手动输入组三或组六号码，3个数字为一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "80",
                            "pid": "9",
                            "series_way_id": "80",
                            "relation_series_way_ids": null,
                            "name_cn": "组选和值",
                            "name_en": "hezhi",
                            "price": "2",
                            "bet_note": "从1-26中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码百位、十位、个位三个数字相加之和(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        },
                        {
                            "id": "9",
                            "pid": "9",
                            "series_way_id": "9",
                            "relation_series_way_ids": null,
                            "name_cn": "组三单式",
                            "name_en": "zusandanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入 1 个三位数号码。(三个数字当中有二个数字相同)",
                            "bonus_note": "手动输入组三号码，3个数字为一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖",
                            "basic_methods": "2"
                        },
                        {
                            "id": "10",
                            "pid": "9",
                            "series_way_id": "10",
                            "relation_series_way_ids": null,
                            "name_cn": "组六单式",
                            "name_en": "zuliudanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入 1 个三位数号码。(三个数字全不相同)",
                            "bonus_note": "手动输入组六号码，3个数字为一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖",
                            "basic_methods": "3"
                        },
                        {
                            "id": "83",
                            "pid": "9",
                            "series_way_id": "83",
                            "relation_series_way_ids": null,
                            "name_cn": "包胆",
                            "name_en": "baodan",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码。",
                            "bonus_note": "从0-9中任意选择1个包胆号码，开奖号码的百位、十位、个位中任意1位与所选包胆号码相同(不含豹子号)，即为中奖。",
                            "basic_methods": "2,3"
                        }
                    ]
                },
                {
                    "id": "14",
                    "pid": "1",
                    "name_cn": "其它",
                    "name_en": "qita",
                    "children": [
                        {
                            "id": "54",
                            "pid": "14",
                            "series_way_id": "54",
                            "relation_series_way_ids": null,
                            "name_cn": "和值尾数",
                            "name_en": "hezhiweishu",
                            "price": "2",
                            "bet_note": "从0-9中选择1个号码",
                            "bonus_note": "所选数值等于开奖号码的百位、十位、个位三个数字相加之和的尾数，即为中奖。",
                            "basic_methods": "23"
                        },
                        {
                            "id": "57",
                            "pid": "14",
                            "series_way_id": "57",
                            "relation_series_way_ids": null,
                            "name_cn": "特殊号码",
                            "name_en": "teshuhaoma",
                            "price": "2",
                            "bet_note": "选择一个号码形态",
                            "bonus_note": "豹子：开奖号码的百位十位个位数字都相同。\r\n顺子：开奖号码的百位十位个位数字都相连，不分顺序（数字9、0、1相连）。\r\n对子：开奖号码的百位十位个位任意两位数字相同（不包括豹子）。\r\n半顺：开奖号码的百位十位个位任意两位数字相连，不分顺序（不包括顺子、对子）。\r\n杂六：不包括豹子、对子、顺子、半顺的所有开奖号码。",
                            "basic_methods": "38,39,40,90,91"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "15",
            "pid": 0,
            "name_cn": "二星",
            "name_en": "erxing",
            "children": [
                {
                    "id": "16",
                    "pid": "15",
                    "name_cn": "直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "70",
                            "pid": "16",
                            "series_way_id": "70",
                            "relation_series_way_ids": null,
                            "name_cn": "后二复式",
                            "name_en": "houerfushi",
                            "price": "2",
                            "bet_note": "从十、个位各选一个号码组成一注",
                            "bonus_note": "从十位、个位中选择一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "11",
                            "pid": "16",
                            "series_way_id": "11",
                            "relation_series_way_ids": null,
                            "name_cn": "后二单式",
                            "name_en": "houerdanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个两位数号码",
                            "bonus_note": "手动输入一个2位数号码组成一注，所选号码的十位、个位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "74",
                            "pid": "16",
                            "series_way_id": "74",
                            "relation_series_way_ids": null,
                            "name_cn": "后二和值",
                            "name_en": "houerhezhi",
                            "price": "2",
                            "bet_note": "从0-18中任意选择1个或1个以上号码",
                            "bonus_note": "所选数值等于开奖号码的十位、个位二个数字相加之和，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "63",
                            "pid": "16",
                            "series_way_id": "63",
                            "relation_series_way_ids": null,
                            "name_cn": "后二跨度",
                            "name_en": "houerkuadu",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个号码 ",
                            "bonus_note": "所选数值等于开奖号码的后2位最大与最小数字相减之差，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "66",
                            "pid": "16",
                            "series_way_id": "66",
                            "relation_series_way_ids": null,
                            "name_cn": "前二复式",
                            "name_en": "qianerfushi",
                            "price": "2",
                            "bet_note": "从第一位、第二位中至少各选择1个号码",
                            "bonus_note": "从01-11共11个号码中选择2个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "4",
                            "pid": "16",
                            "series_way_id": "4",
                            "relation_series_way_ids": null,
                            "name_cn": "前二单式",
                            "name_en": "qianerdanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个两位数号码",
                            "bonus_note": "手动输入一个2位数号码组成一注，所选号码的万位、千位与开奖号码相同，且顺序一致，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "72",
                            "pid": "16",
                            "series_way_id": "72",
                            "relation_series_way_ids": null,
                            "name_cn": "前二和值",
                            "name_en": "qianerhezhi",
                            "price": "2",
                            "bet_note": "从0-18中任意选择1个或1个以上号码",
                            "bonus_note": "所选数值等于开奖号码的万位、千位二个数字相加之和，即为中奖。",
                            "basic_methods": "5"
                        },
                        {
                            "id": "61",
                            "pid": "16",
                            "series_way_id": "61",
                            "relation_series_way_ids": null,
                            "name_cn": "前二跨度",
                            "name_en": "qianerkuadu",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个号码。",
                            "bonus_note": "所选数值等于开奖号码的前2位最大与最小数字相减之差，即为中奖。",
                            "basic_methods": "5"
                        }
                    ]
                },
                {
                    "id": "17",
                    "pid": "15",
                    "name_cn": "组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "59",
                            "pid": "17",
                            "series_way_id": "59",
                            "relation_series_way_ids": null,
                            "name_cn": "后二复式",
                            "name_en": "houerfushi",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个或2个以上号码。",
                            "bonus_note": "从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同，顺序不限（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "12",
                            "pid": "17",
                            "series_way_id": "12",
                            "relation_series_way_ids": null,
                            "name_cn": "后二单式",
                            "name_en": "houerdanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个两位数号码",
                            "bonus_note": "手动输入一个2位数号码组成一注，所选号码的十位、个位与开奖号码相同，顺序不限（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "77",
                            "pid": "17",
                            "series_way_id": "77",
                            "relation_series_way_ids": null,
                            "name_cn": "后二和值",
                            "name_en": "houerhezhi",
                            "price": "2",
                            "bet_note": "从1-17中任意选择1个或1个以上号码",
                            "bonus_note": "所选数值等于开奖号码的十位、个位二个数字相加之和（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "85",
                            "pid": "17",
                            "series_way_id": "85",
                            "relation_series_way_ids": null,
                            "name_cn": "后二包胆",
                            "name_en": "houerbaodan",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个包胆号码",
                            "bonus_note": "从0-9中任意选择1个包胆号码，开奖号码的十位、个位中任意1位包含所选的包胆号码相同（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "20",
                            "pid": "17",
                            "series_way_id": "20",
                            "relation_series_way_ids": null,
                            "name_cn": "前二复式",
                            "name_en": "qianerfushi",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个或2个以上号码。",
                            "bonus_note": "从0-9中选2个号码组成一注，所选号码与开奖号码的百位、十位相同，顺序不限（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "5",
                            "pid": "17",
                            "series_way_id": "5",
                            "relation_series_way_ids": null,
                            "name_cn": "前二单式",
                            "name_en": "qianerdanshi",
                            "price": "2",
                            "bet_note": "手动输入号码，至少输入1个两位数号码组成一注",
                            "bonus_note": "手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "76",
                            "pid": "17",
                            "series_way_id": "76",
                            "relation_series_way_ids": null,
                            "name_cn": "前二和值",
                            "name_en": "qianerhezhi",
                            "price": "2",
                            "bet_note": "从1-17中任意选择1个或1个以上号码",
                            "bonus_note": "所选数值等于开奖号码的万位、千位二个数字相加之和（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        },
                        {
                            "id": "84",
                            "pid": "17",
                            "series_way_id": "84",
                            "relation_series_way_ids": null,
                            "name_cn": "前二包胆",
                            "name_en": "qianerbaodan",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个包胆号码",
                            "bonus_note": "从0-9中任意选择1个包胆号码，开奖号码的万位、千位中任意1位包含所选的包胆号码相同（不含对子号），即为中奖。",
                            "basic_methods": "8"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "18",
            "pid": 0,
            "name_cn": "一星",
            "name_en": "yixing",
            "children": [
                {
                    "id": "19",
                    "pid": "18",
                    "name_cn": "定位胆",
                    "name_en": "dingweidan",
                    "children": [
                        {
                            "id": "78",
                            "pid": "19",
                            "series_way_id": "78",
                            "relation_series_way_ids": null,
                            "name_cn": "定位胆",
                            "name_en": "fushi",
                            "price": "2",
                            "bet_note": "在万位，千位，百位，十位，个位任意位置上任意选择1个或1个以上号码",
                            "bonus_note": "从万位、千位、百位、十位、个位任意位置上至少选择1个以上号码，所选号码与相同位置上的开奖号码一致，即为中奖。",
                            "basic_methods": "6,6,6,6,6"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "20",
            "pid": 0,
            "name_cn": "不定位",
            "name_en": "budingwei",
            "children": [
                {
                    "id": "21",
                    "pid": "20",
                    "name_cn": "三星不定位",
                    "name_en": "sanxingbudingwei",
                    "children": [
                        {
                            "id": "51",
                            "pid": "21",
                            "series_way_id": "51",
                            "relation_series_way_ids": null,
                            "name_cn": "后三一码不定位",
                            "name_en": "housanyimabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上号码",
                            "bonus_note": "从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的百位、十位、个位中包含所选号码，即为中奖。",
                            "basic_methods": "4"
                        },
                        {
                            "id": "52",
                            "pid": "21",
                            "series_way_id": "52",
                            "relation_series_way_ids": null,
                            "name_cn": "后三二码不定位",
                            "name_en": "housanermabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个以上号码",
                            "bonus_note": "从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。",
                            "basic_methods": "9"
                        },
                        {
                            "id": "18",
                            "pid": "21",
                            "series_way_id": "18",
                            "relation_series_way_ids": null,
                            "name_cn": "前三一码不定位",
                            "name_en": "qiansanyimabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上号码",
                            "bonus_note": "从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的万位、千位、百位中包含所选号码，即为中奖。",
                            "basic_methods": "4"
                        },
                        {
                            "id": "21",
                            "pid": "21",
                            "series_way_id": "21",
                            "relation_series_way_ids": null,
                            "name_cn": "前三二码不定位",
                            "name_en": "qiansanermabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个以上号码",
                            "bonus_note": "从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位中同时包含所选的2个号码，即为中奖。",
                            "basic_methods": "9"
                        }
                    ]
                },
                {
                    "id": "22",
                    "pid": "20",
                    "name_cn": "四星不定位",
                    "name_en": "sixingbudingwei",
                    "children": [
                        {
                            "id": "34",
                            "pid": "22",
                            "series_way_id": "34",
                            "relation_series_way_ids": null,
                            "name_cn": "四星一码不定位",
                            "name_en": "sixingyimabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上号码",
                            "bonus_note": "从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的千位、百位、十位、个位中包含所选号码，即为中奖。",
                            "basic_methods": "24"
                        },
                        {
                            "id": "35",
                            "pid": "22",
                            "series_way_id": "35",
                            "relation_series_way_ids": null,
                            "name_cn": "四星二码不定位",
                            "name_en": "sixingermabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个以上号码",
                            "bonus_note": "从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的千位、百位、十位、个位中同时包含所选的2个号码，即为中奖",
                            "basic_methods": "25"
                        }
                    ]
                },
                {
                    "id": "23",
                    "pid": "20",
                    "name_cn": "五星不定位",
                    "name_en": "wuxingbudingwei",
                    "children": [
                        {
                            "id": "36",
                            "pid": "23",
                            "series_way_id": "36",
                            "relation_series_way_ids": null,
                            "name_cn": "五星二码不定位",
                            "name_en": "wuxingermabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择2个以上号码",
                            "bonus_note": "从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位、十位、个位中同时包含所选的2个号码，即为中奖。",
                            "basic_methods": "26"
                        },
                        {
                            "id": "37",
                            "pid": "23",
                            "series_way_id": "37",
                            "relation_series_way_ids": null,
                            "name_cn": "五星三码不定位",
                            "name_en": "wuxingsanmabudingwei",
                            "price": "2",
                            "bet_note": "从0-9中任意选择3个以上号码",
                            "bonus_note": "从0-9中选择3个号码，每注由3个不同的号码组成，开奖号码的万位、千位、百位、十位、个位中同时包含所选的3个号码，即为中奖。",
                            "basic_methods": "27"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "24",
            "pid": 0,
            "name_cn": "大小单双",
            "name_en": "daxiaodanshuang",
            "children": [
                {
                    "id": "25",
                    "pid": "24",
                    "name_cn": "大小单双",
                    "name_en": "daxiaodanshuang",
                    "children": [
                        {
                            "id": "58",
                            "pid": "25",
                            "series_way_id": "58",
                            "relation_series_way_ids": null,
                            "name_cn": "后二大小单双",
                            "name_en": "houerdaxiaodanshuang",
                            "price": "2",
                            "bet_note": "从十位、个位中的“大、小、单、双”中至少各选一个组成一注",
                            "bonus_note": "对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。",
                            "basic_methods": "7"
                        },
                        {
                            "id": "53",
                            "pid": "25",
                            "series_way_id": "53",
                            "relation_series_way_ids": null,
                            "name_cn": "后三大小单双",
                            "name_en": "housandaxiaodanshuang",
                            "price": "2",
                            "bet_note": "从百位、十位、个位中的“大、小、单、双”中至少各选一个组成一注",
                            "bonus_note": "对百位、十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。",
                            "basic_methods": "10"
                        },
                        {
                            "id": "19",
                            "pid": "25",
                            "series_way_id": "19",
                            "relation_series_way_ids": null,
                            "name_cn": "前二大小单双",
                            "name_en": "qianerdaxiaodanshuang",
                            "price": "2",
                            "bet_note": "从万位、千位中的“大、小、单、双”中至少各选一个组成一注",
                            "bonus_note": "对万位、千位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。",
                            "basic_methods": "7"
                        },
                        {
                            "id": "22",
                            "pid": "25",
                            "series_way_id": "22",
                            "relation_series_way_ids": null,
                            "name_cn": "前三大小单双",
                            "name_en": "qiansandaxiaodanshuang",
                            "price": "2",
                            "bet_note": "从万位、千位、百位中的“大、小、单、双”中至少各选一个组成一注",
                            "bonus_note": "对万位、千位和百位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。",
                            "basic_methods": "10"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "26",
            "pid": 0,
            "name_cn": "趣味",
            "name_en": "quwei",
            "children": [
                {
                    "id": "27",
                    "pid": "26",
                    "name_cn": "趣味",
                    "name_en": "quwei",
                    "children": [
                        {
                            "id": "38",
                            "pid": "27",
                            "series_way_id": "38",
                            "relation_series_way_ids": null,
                            "name_cn": "五码趣味三星",
                            "name_en": "wumaquweisanxing",
                            "price": "2",
                            "bet_note": "分别从万位与千位中各选择一个大小号属性，并从百位、十位、个位中至少各选1个号码组成一注",
                            "bonus_note": "在个位、十位、百位上至少各选1个号码，并从千位与万位的“大小号”中分别任选一种号码进行投注。其中，0-4为“小号”；5-9为“大号”。投注内容只要和开奖号码的后三位相同，顺序一致，即可中奖。",
                            "basic_methods": "28"
                        },
                        {
                            "id": "39",
                            "pid": "27",
                            "series_way_id": "39",
                            "relation_series_way_ids": null,
                            "name_cn": "四码趣味三星",
                            "name_en": "simaquweisanxing",
                            "price": "2",
                            "bet_note": "选择一个千位的大小号属性，并从百位、十位、个位中至少各选1个号码",
                            "bonus_note": "在个位、十位、百位上至少各选1个号码，并从千位“大小号”中任选一种号码属性进行投注。其中，0-4为“小号”；5-9为“大号”。投注内容只要和开奖号码的后三位相同，顺序一致，即可中奖。",
                            "basic_methods": "29"
                        },
                        {
                            "id": "55",
                            "pid": "27",
                            "series_way_id": "55",
                            "relation_series_way_ids": null,
                            "name_cn": "后三趣味二星",
                            "name_en": "housanquweierxing",
                            "price": "2",
                            "bet_note": "选择一个百位的大小号属性，并从十位、个位中至少各选1个号码",
                            "bonus_note": "在个位、十位上至少各选1个号码，并从百位“大小号”中任选一种号码属性进行投注。其中，0-4为“小号”；5-9为“大号”。投注内容和开奖号码的后二位相同，顺序一致，即可中奖。",
                            "basic_methods": "30"
                        },
                        {
                            "id": "40",
                            "pid": "27",
                            "series_way_id": "40",
                            "relation_series_way_ids": null,
                            "name_cn": "前三趣味二星",
                            "name_en": "qiansanquweierxing",
                            "price": "2",
                            "bet_note": "选择一个万位的大小号属性，并从千位、百位中至少各选1个号码",
                            "bonus_note": "在千位、百位上至少各选1个号码，并从万位 “大小号”中任选一种号码属性进行投注。0-4为“小号”；5-9为“大号”。投注内容只要和开奖号码的千位和百位相同，顺序一致，即可中奖。",
                            "basic_methods": "30"
                        }
                    ]
                },
                {
                    "id": "28",
                    "pid": "26",
                    "name_cn": "区间",
                    "name_en": "qujian",
                    "children": [
                        {
                            "id": "41",
                            "pid": "28",
                            "series_way_id": "41",
                            "relation_series_way_ids": null,
                            "name_cn": "五码区间三星",
                            "name_en": "wumaqujiansanxing",
                            "price": "2",
                            "bet_note": "分别从万位与千位中各选择一个区间，并从百位、十位、个位中至少各选1个号码组成一注",
                            "bonus_note": "在个位、十位、百位上至少各选1个号码，并从千位及万位的5个区间中至少分别选择一个区间进行投注。投注内容只要和开奖号码的后三位相同，顺序一致，即可中奖。",
                            "basic_methods": "31"
                        },
                        {
                            "id": "42",
                            "pid": "28",
                            "series_way_id": "42",
                            "relation_series_way_ids": null,
                            "name_cn": "四码区间三星",
                            "name_en": "simaqujiansanxing",
                            "price": "2",
                            "bet_note": "选择一个千位号码区间，并从百位、十位、个位中至少各选择1个号码组成一注",
                            "bonus_note": "在个位、十位、百位上至少各选1个号码，并从千位的5个区间中至少任选一个区间进行投注。投注内容只要和开奖号码的后三位相同，顺序一致，即可中奖。",
                            "basic_methods": "32"
                        },
                        {
                            "id": "56",
                            "pid": "28",
                            "series_way_id": "56",
                            "relation_series_way_ids": null,
                            "name_cn": "后三区间二星",
                            "name_en": "housanqujianerxing",
                            "price": "2",
                            "bet_note": "选择一个百位号码区间，并从十位、个位中至少各选择1个号码组成一注",
                            "bonus_note": "选择一个百位号码区间，并从十位、个位中各选择1个号码组成一注。投注内容只要和开奖号码的后二位相同，顺序一致，即可中奖。",
                            "basic_methods": "33"
                        },
                        {
                            "id": "43",
                            "pid": "28",
                            "series_way_id": "43",
                            "relation_series_way_ids": null,
                            "name_cn": "前三区间二星",
                            "name_en": "qiansanqujianerxing",
                            "price": "2",
                            "bet_note": "选择一个万位号码区间，并从千位、百位中至少各选择1个号码组成一注",
                            "bonus_note": "选择一个万位号码区间，并从千位、百位中至少各选择1个号码组成一注。投注内容只要和开奖号码的千位和百位相同，顺序一致，即可中奖。",
                            "basic_methods": "33"
                        }
                    ]
                },
                {
                    "id": "29",
                    "pid": "26",
                    "name_cn": "特殊",
                    "name_en": "teshu",
                    "children": [
                        {
                            "id": "44",
                            "pid": "29",
                            "series_way_id": "44",
                            "relation_series_way_ids": null,
                            "name_cn": "一帆风顺",
                            "name_en": "yifanfengshun",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上号码",
                            "bonus_note": "从0-9中任意选择1个号码组成一注，只要开奖号码的万位、千位、百位、十位、个位中包含所选号码，即为中奖。",
                            "basic_methods": "34"
                        },
                        {
                            "id": "45",
                            "pid": "29",
                            "series_way_id": "45",
                            "relation_series_way_ids": null,
                            "name_cn": "好事成双",
                            "name_en": "haoshichengshuang",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上的二重号码",
                            "bonus_note": "从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现2次，即为中奖。",
                            "basic_methods": "35"
                        },
                        {
                            "id": "46",
                            "pid": "29",
                            "series_way_id": "46",
                            "relation_series_way_ids": null,
                            "name_cn": "三星报喜",
                            "name_en": "sanxingbaoxi",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上的三重号码",
                            "bonus_note": "从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现3次，即为中奖。",
                            "basic_methods": "36"
                        },
                        {
                            "id": "47",
                            "pid": "29",
                            "series_way_id": "47",
                            "relation_series_way_ids": null,
                            "name_cn": "四季发财",
                            "name_en": "sijifacai",
                            "price": "2",
                            "bet_note": "从0-9中任意选择1个以上的四重号码",
                            "bonus_note": "从0-9中任意选择1个号码组成一注，只要所选号码在开奖号码的万位、千位、百位、十位、个位中出现4次，即为中奖。",
                            "basic_methods": "37"
                        }
                    ]
                }
            ],
            "isRenxuan": false
        },
        {
            "id": "109",
            "pid": 0,
            "name_cn": "任选二",
            "name_en": "renxuaner",
            "children": [
                {
                    "id": "112",
                    "pid": "109",
                    "name_cn": "任二直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "186",
                            "pid": "112",
                            "series_way_id": "186",
                            "relation_series_way_ids": "207,220,233,280,299,305,318,331,350,363",
                            "name_cn": "直选复式",
                            "name_en": "zhixuanfushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "92",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "207",
                                    "basic_methods": "92",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "220",
                                    "basic_methods": "92",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "233",
                                    "basic_methods": "92",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "280",
                                    "basic_methods": "92",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "299",
                                    "basic_methods": "92",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "305",
                                    "basic_methods": "92",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "318",
                                    "basic_methods": "92",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "331",
                                    "basic_methods": "92",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "350",
                                    "basic_methods": "92",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "363",
                                    "basic_methods": "92",
                                    "index": "2,3"
                                }
                            ]
                        },
                        {
                            "id": "187",
                            "pid": "112",
                            "series_way_id": "187",
                            "relation_series_way_ids": "208,221,234,281,300,306,319,332,351,364",
                            "name_cn": "直选单式",
                            "name_en": "zhixuandanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "92",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "208",
                                    "basic_methods": "92",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "221",
                                    "basic_methods": "92",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "234",
                                    "basic_methods": "92",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "281",
                                    "basic_methods": "92",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "300",
                                    "basic_methods": "92",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "306",
                                    "basic_methods": "92",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "319",
                                    "basic_methods": "92",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "332",
                                    "basic_methods": "92",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "351",
                                    "basic_methods": "92",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "364",
                                    "basic_methods": "92",
                                    "index": "2,3"
                                }
                            ]
                        },
                        {
                            "id": "188",
                            "pid": "112",
                            "series_way_id": "188",
                            "relation_series_way_ids": "209,222,235,282,301,307,320,333,352,365",
                            "name_cn": "直选和值",
                            "name_en": "zhixuanhezhi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "92",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "209",
                                    "basic_methods": "92",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "222",
                                    "basic_methods": "92",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "235",
                                    "basic_methods": "92",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "282",
                                    "basic_methods": "92",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "301",
                                    "basic_methods": "92",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "307",
                                    "basic_methods": "92",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "320",
                                    "basic_methods": "92",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "333",
                                    "basic_methods": "92",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "352",
                                    "basic_methods": "92",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "365",
                                    "basic_methods": "92",
                                    "index": "2,3"
                                }
                            ]
                        }
                    ]
                },
                {
                    "id": "113",
                    "pid": "109",
                    "name_cn": "任二组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "204",
                            "pid": "113",
                            "series_way_id": "204",
                            "relation_series_way_ids": "210,223,236,283,302,308,321,334,353,366",
                            "name_cn": "组选复式",
                            "name_en": "zuxuanfushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "8",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "210",
                                    "basic_methods": "8",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "223",
                                    "basic_methods": "8",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "236",
                                    "basic_methods": "8",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "283",
                                    "basic_methods": "8",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "302",
                                    "basic_methods": "8",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "308",
                                    "basic_methods": "8",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "321",
                                    "basic_methods": "8",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "334",
                                    "basic_methods": "8",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "353",
                                    "basic_methods": "8",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "366",
                                    "basic_methods": "8",
                                    "index": "2,3"
                                }
                            ]
                        },
                        {
                            "id": "205",
                            "pid": "113",
                            "series_way_id": "205",
                            "relation_series_way_ids": "211,224,237,284,303,309,322,335,354,367",
                            "name_cn": "组选单式",
                            "name_en": "zuxuandanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "8",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "211",
                                    "basic_methods": "8",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "224",
                                    "basic_methods": "8",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "237",
                                    "basic_methods": "8",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "284",
                                    "basic_methods": "8",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "303",
                                    "basic_methods": "8",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "309",
                                    "basic_methods": "8",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "322",
                                    "basic_methods": "8",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "335",
                                    "basic_methods": "8",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "354",
                                    "basic_methods": "8",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "367",
                                    "basic_methods": "8",
                                    "index": "2,3"
                                }
                            ]
                        },
                        {
                            "id": "206",
                            "pid": "113",
                            "series_way_id": "206",
                            "relation_series_way_ids": "212,225,238,285,304,310,323,336,355,368",
                            "name_cn": "组选和值",
                            "name_en": "zuxuanhezhi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "8",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "212",
                                    "basic_methods": "8",
                                    "index": "0,4"
                                },
                                {
                                    "series_way_id": "225",
                                    "basic_methods": "8",
                                    "index": "0,3"
                                },
                                {
                                    "series_way_id": "238",
                                    "basic_methods": "8",
                                    "index": "0,1"
                                },
                                {
                                    "series_way_id": "285",
                                    "basic_methods": "8",
                                    "index": "0,2"
                                },
                                {
                                    "series_way_id": "304",
                                    "basic_methods": "8",
                                    "index": "3,4"
                                },
                                {
                                    "series_way_id": "310",
                                    "basic_methods": "8",
                                    "index": "1,4"
                                },
                                {
                                    "series_way_id": "323",
                                    "basic_methods": "8",
                                    "index": "1,3"
                                },
                                {
                                    "series_way_id": "336",
                                    "basic_methods": "8",
                                    "index": "1,2"
                                },
                                {
                                    "series_way_id": "355",
                                    "basic_methods": "8",
                                    "index": "2,4"
                                },
                                {
                                    "series_way_id": "368",
                                    "basic_methods": "8",
                                    "index": "2,3"
                                }
                            ]
                        }
                    ]
                }
            ],
            "isRenxuan": true
        },
        {
            "id": "110",
            "pid": 0,
            "name_cn": "任选三",
            "name_en": "renxuansan",
            "children": [
                {
                    "id": "114",
                    "pid": "110",
                    "name_cn": "任三直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "189",
                            "pid": "114",
                            "series_way_id": "189",
                            "relation_series_way_ids": "213,226,245,258,272,292,311,324,343,356",
                            "name_cn": "直选复式",
                            "name_en": "zhixuanfushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "93",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "213",
                                    "basic_methods": "93",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "226",
                                    "basic_methods": "93",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "245",
                                    "basic_methods": "93",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "258",
                                    "basic_methods": "93",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "272",
                                    "basic_methods": "93",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "292",
                                    "basic_methods": "93",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "311",
                                    "basic_methods": "93",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "324",
                                    "basic_methods": "93",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "343",
                                    "basic_methods": "93",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "356",
                                    "basic_methods": "93",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "190",
                            "pid": "114",
                            "series_way_id": "190",
                            "relation_series_way_ids": "214,227,246,259,273,293,312,325,344,357",
                            "name_cn": "直选单式",
                            "name_en": "zhixuandanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "93",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "214",
                                    "basic_methods": "93",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "227",
                                    "basic_methods": "93",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "246",
                                    "basic_methods": "93",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "259",
                                    "basic_methods": "93",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "273",
                                    "basic_methods": "93",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "293",
                                    "basic_methods": "93",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "312",
                                    "basic_methods": "93",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "325",
                                    "basic_methods": "93",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "344",
                                    "basic_methods": "93",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "357",
                                    "basic_methods": "93",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "191",
                            "pid": "114",
                            "series_way_id": "191",
                            "relation_series_way_ids": "215,228,247,260,274,294,313,326,345,358",
                            "name_cn": "直选和值",
                            "name_en": "zhixuanhezhi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "93",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "215",
                                    "basic_methods": "93",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "228",
                                    "basic_methods": "93",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "247",
                                    "basic_methods": "93",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "260",
                                    "basic_methods": "93",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "274",
                                    "basic_methods": "93",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "294",
                                    "basic_methods": "93",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "313",
                                    "basic_methods": "93",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "326",
                                    "basic_methods": "93",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "345",
                                    "basic_methods": "93",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "358",
                                    "basic_methods": "93",
                                    "index": "2,3,4"
                                }
                            ]
                        }
                    ]
                },
                {
                    "id": "115",
                    "pid": "110",
                    "name_cn": "任三组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "198",
                            "pid": "115",
                            "series_way_id": "198",
                            "relation_series_way_ids": "216,229,248,261,275,295,314,327,346,359",
                            "name_cn": "组三复式",
                            "name_en": "zusanfushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "2",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "216",
                                    "basic_methods": "2",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "229",
                                    "basic_methods": "2",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "248",
                                    "basic_methods": "2",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "261",
                                    "basic_methods": "2",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "275",
                                    "basic_methods": "2",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "295",
                                    "basic_methods": "2",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "314",
                                    "basic_methods": "2",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "327",
                                    "basic_methods": "2",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "346",
                                    "basic_methods": "2",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "359",
                                    "basic_methods": "2",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "199",
                            "pid": "115",
                            "series_way_id": "199",
                            "relation_series_way_ids": "217,230,249,262,276,296,315,328,347,360",
                            "name_cn": "组三单式",
                            "name_en": "zusandanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "2",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "217",
                                    "basic_methods": "2",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "230",
                                    "basic_methods": "2",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "249",
                                    "basic_methods": "2",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "262",
                                    "basic_methods": "2",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "276",
                                    "basic_methods": "2",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "296",
                                    "basic_methods": "2",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "315",
                                    "basic_methods": "2",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "328",
                                    "basic_methods": "2",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "347",
                                    "basic_methods": "2",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "360",
                                    "basic_methods": "2",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "200",
                            "pid": "115",
                            "series_way_id": "200",
                            "relation_series_way_ids": "218,231,250,263,277,297,316,329,348,361",
                            "name_cn": "组六复式",
                            "name_en": "zuliufushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "3",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "218",
                                    "basic_methods": "3",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "231",
                                    "basic_methods": "3",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "250",
                                    "basic_methods": "3",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "263",
                                    "basic_methods": "3",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "277",
                                    "basic_methods": "3",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "297",
                                    "basic_methods": "3",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "316",
                                    "basic_methods": "3",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "329",
                                    "basic_methods": "3",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "348",
                                    "basic_methods": "3",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "361",
                                    "basic_methods": "3",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "201",
                            "pid": "115",
                            "series_way_id": "201",
                            "relation_series_way_ids": "219,232,251,264,279,298,317,330,349,362",
                            "name_cn": "组六单式",
                            "name_en": "zuliudanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "3",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "219",
                                    "basic_methods": "3",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "232",
                                    "basic_methods": "3",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "251",
                                    "basic_methods": "3",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "264",
                                    "basic_methods": "3",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "279",
                                    "basic_methods": "3",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "298",
                                    "basic_methods": "3",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "317",
                                    "basic_methods": "3",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "330",
                                    "basic_methods": "3",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "349",
                                    "basic_methods": "3",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "362",
                                    "basic_methods": "3",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "202",
                            "pid": "115",
                            "series_way_id": "202",
                            "relation_series_way_ids": "396,397,398,399,400,401,402,403,404,405",
                            "name_cn": "混合组选",
                            "name_en": "hunhezuxuan",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "3,2",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "396",
                                    "basic_methods": "2,3",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "397",
                                    "basic_methods": "2,3",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "398",
                                    "basic_methods": "2,3",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "399",
                                    "basic_methods": "2,3",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "400",
                                    "basic_methods": "2,3",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "401",
                                    "basic_methods": "2,3",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "402",
                                    "basic_methods": "2,3",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "403",
                                    "basic_methods": "2,3",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "404",
                                    "basic_methods": "2,3",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "405",
                                    "basic_methods": "2,3",
                                    "index": "2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "203",
                            "pid": "115",
                            "series_way_id": "203",
                            "relation_series_way_ids": "385,386,387,388,389,390,391,392,394,395",
                            "name_cn": "组选和值",
                            "name_en": "zuxuanhezhi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "3,2",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "385",
                                    "basic_methods": "2,3",
                                    "index": "0,1,2"
                                },
                                {
                                    "series_way_id": "386",
                                    "basic_methods": "2,3",
                                    "index": "0,1,3"
                                },
                                {
                                    "series_way_id": "387",
                                    "basic_methods": "2,3",
                                    "index": "0,1,4"
                                },
                                {
                                    "series_way_id": "388",
                                    "basic_methods": "2,3",
                                    "index": "0,2,3"
                                },
                                {
                                    "series_way_id": "389",
                                    "basic_methods": "2,3",
                                    "index": "0,2,4"
                                },
                                {
                                    "series_way_id": "390",
                                    "basic_methods": "2,3",
                                    "index": "1,2,3"
                                },
                                {
                                    "series_way_id": "391",
                                    "basic_methods": "2,3",
                                    "index": "1,2,4"
                                },
                                {
                                    "series_way_id": "392",
                                    "basic_methods": "2,3",
                                    "index": "1,3,4"
                                },
                                {
                                    "series_way_id": "394",
                                    "basic_methods": "2,3",
                                    "index": "0,3,4"
                                },
                                {
                                    "series_way_id": "395",
                                    "basic_methods": "2,3",
                                    "index": "2,3,4"
                                }
                            ]
                        }
                    ]
                }
            ],
            "isRenxuan": true
        },
        {
            "id": "111",
            "pid": 0,
            "name_cn": "任选四",
            "name_en": "renxuansi",
            "children": [
                {
                    "id": "116",
                    "pid": "111",
                    "name_cn": "任四直选",
                    "name_en": "zhixuan",
                    "children": [
                        {
                            "id": "192",
                            "pid": "116",
                            "series_way_id": "192",
                            "relation_series_way_ids": "239,252,266,286,337",
                            "name_cn": "直选复式",
                            "name_en": "zhixuanfushi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "94",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "239",
                                    "basic_methods": "94",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "252",
                                    "basic_methods": "94",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "266",
                                    "basic_methods": "94",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "286",
                                    "basic_methods": "94",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "337",
                                    "basic_methods": "94",
                                    "index": "1,2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "193",
                            "pid": "116",
                            "series_way_id": "193",
                            "relation_series_way_ids": "240,253,267,287,338",
                            "name_cn": "直选单式",
                            "name_en": "zhixuandanshi",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "94",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "240",
                                    "basic_methods": "94",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "253",
                                    "basic_methods": "94",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "267",
                                    "basic_methods": "94",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "287",
                                    "basic_methods": "94",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "338",
                                    "basic_methods": "94",
                                    "index": "1,2,3,4"
                                }
                            ]
                        }
                    ]
                },
                {
                    "id": "117",
                    "pid": "111",
                    "name_cn": "任四组选",
                    "name_en": "zuxuan",
                    "children": [
                        {
                            "id": "197",
                            "pid": "117",
                            "series_way_id": "197",
                            "relation_series_way_ids": "242,255,269,289,340",
                            "name_cn": "组选24",
                            "name_en": "zuxuan24",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "15",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "242",
                                    "basic_methods": "15",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "255",
                                    "basic_methods": "15",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "269",
                                    "basic_methods": "15",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "289",
                                    "basic_methods": "15",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "340",
                                    "basic_methods": "15",
                                    "index": "1,2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "196",
                            "pid": "117",
                            "series_way_id": "196",
                            "relation_series_way_ids": "241,254,268,288,339",
                            "name_cn": "组选12",
                            "name_en": "zuxuan12",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "14",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "241",
                                    "basic_methods": "14",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "254",
                                    "basic_methods": "14",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "268",
                                    "basic_methods": "14",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "288",
                                    "basic_methods": "14",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "339",
                                    "basic_methods": "14",
                                    "index": "1,2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "195",
                            "pid": "117",
                            "series_way_id": "195",
                            "relation_series_way_ids": "244,257,271,291,342",
                            "name_cn": "组选6",
                            "name_en": "zuxuan6",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "13",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "244",
                                    "basic_methods": "13",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "257",
                                    "basic_methods": "13",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "271",
                                    "basic_methods": "13",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "291",
                                    "basic_methods": "13",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "342",
                                    "basic_methods": "13",
                                    "index": "1,2,3,4"
                                }
                            ]
                        },
                        {
                            "id": "194",
                            "pid": "117",
                            "series_way_id": "194",
                            "relation_series_way_ids": "243,256,270,290,341",
                            "name_cn": "组选4",
                            "name_en": "zuxuan4",
                            "price": "2",
                            "bet_note": null,
                            "bonus_note": null,
                            "basic_methods": "12",
                            "relation_series_ids": [
                                {
                                    "series_way_id": "243",
                                    "basic_methods": "12",
                                    "index": "0,1,3,4"
                                },
                                {
                                    "series_way_id": "256",
                                    "basic_methods": "12",
                                    "index": "0,1,2,4"
                                },
                                {
                                    "series_way_id": "270",
                                    "basic_methods": "12",
                                    "index": "0,1,2,3"
                                },
                                {
                                    "series_way_id": "290",
                                    "basic_methods": "12",
                                    "index": "0,2,3,4"
                                },
                                {
                                    "series_way_id": "341",
                                    "basic_methods": "12",
                                    "index": "1,2,3,4"
                                }
                            ]
                        }
                    ]
                }
            ],
            "isRenxuan": true
        }
    ],
    "defaultMethodId": "69",
    "prizeSettings": {
        "1": {
            "name": "直选单式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "2": {
            "name": "组三单式",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "3": {
            "name": "组六单式",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "4": {
            "name": "前二单式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "5": {
            "name": "前二单式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "6": {
            "name": "直选单式",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": true
        },
        "7": {
            "name": "直选单式",
            "prize": "195500.00",
            "max_multiple": 2,
            "display_prize": true
        },
        "8": {
            "name": "直选单式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "9": {
            "name": "组三单式",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "10": {
            "name": "组六单式",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "11": {
            "name": "后二单式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "12": {
            "name": "后二单式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "13": {
            "name": "混合组选",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "14": {
            "name": "直选组合",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": false
        },
        "15": {
            "name": "直选组合",
            "prize": "195500.00",
            "max_multiple": 2,
            "display_prize": false
        },
        "16": {
            "name": "组三",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "17": {
            "name": "组六",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "18": {
            "name": "前三一码不定位",
            "prize": "7.21",
            "max_multiple": 55478,
            "display_prize": true
        },
        "19": {
            "name": "前二大小单双",
            "prize": "7.82",
            "max_multiple": 51150,
            "display_prize": true
        },
        "20": {
            "name": "前二复式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "21": {
            "name": "前三二码不定位",
            "prize": "36.20",
            "max_multiple": 11049,
            "display_prize": true
        },
        "22": {
            "name": "前三大小单双",
            "prize": "15.64",
            "max_multiple": 25575,
            "display_prize": true
        },
        "23": {
            "name": "组选4",
            "prize": "4887.50",
            "max_multiple": 81,
            "display_prize": true
        },
        "24": {
            "name": "组选6",
            "prize": "3258.33",
            "max_multiple": 122,
            "display_prize": true
        },
        "25": {
            "name": "组选12",
            "prize": "1629.17",
            "max_multiple": 245,
            "display_prize": true
        },
        "26": {
            "name": "组选24",
            "prize": "814.58",
            "max_multiple": 491,
            "display_prize": true
        },
        "27": {
            "name": "组选5",
            "prize": "39100.00",
            "max_multiple": 10,
            "display_prize": true
        },
        "28": {
            "name": "组选10",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": true
        },
        "29": {
            "name": "组选20",
            "prize": "9775.00",
            "max_multiple": 40,
            "display_prize": true
        },
        "30": {
            "name": "组选30",
            "prize": "6516.67",
            "max_multiple": 61,
            "display_prize": true
        },
        "31": {
            "name": "组选60",
            "prize": "3191.84",
            "max_multiple": 125,
            "display_prize": true
        },
        "32": {
            "name": "组选120",
            "prize": "1629.17",
            "max_multiple": 245,
            "display_prize": true
        },
        "33": {
            "name": "和值尾数",
            "prize": "19.55",
            "max_multiple": 20460,
            "display_prize": true
        },
        "34": {
            "name": "四星一码不定位",
            "prize": "5.68",
            "max_multiple": 70422,
            "display_prize": true
        },
        "35": {
            "name": "四星二码不定位",
            "prize": "20.07",
            "max_multiple": 19930,
            "display_prize": true
        },
        "36": {
            "name": "五星二码不定位",
            "prize": "13.33",
            "max_multiple": 30007,
            "display_prize": true
        },
        "37": {
            "name": "五星三码不定位",
            "prize": "44.94",
            "max_multiple": 8900,
            "display_prize": true
        },
        "38": {
            "name": "五码趣味三星",
            "prize": "7820.00",
            "max_multiple": 51,
            "display_prize": true
        },
        "39": {
            "name": "四码趣味三星",
            "prize": "3910.00",
            "max_multiple": 102,
            "display_prize": true
        },
        "40": {
            "name": "前三趣味二星",
            "prize": "391.00",
            "max_multiple": 1023,
            "display_prize": true
        },
        "41": {
            "name": "五码区间三星",
            "prize": "48875.00",
            "max_multiple": 8,
            "display_prize": true
        },
        "42": {
            "name": "四码区间三星",
            "prize": "9775.00",
            "max_multiple": 40,
            "display_prize": true
        },
        "43": {
            "name": "前三区间二星",
            "prize": "977.50",
            "max_multiple": 409,
            "display_prize": true
        },
        "44": {
            "name": "一帆风顺",
            "prize": "4.77",
            "max_multiple": 83857,
            "display_prize": true
        },
        "45": {
            "name": "好事成双",
            "prize": "24.00",
            "max_multiple": 16666,
            "display_prize": true
        },
        "46": {
            "name": "三星报喜",
            "prize": "228.39",
            "max_multiple": 1751,
            "display_prize": true
        },
        "47": {
            "name": "四季发财",
            "prize": "4250.00",
            "max_multiple": 94,
            "display_prize": true
        },
        "48": {
            "name": "特殊号码",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": false
        },
        "49": {
            "name": "组三",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "50": {
            "name": "组六",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "51": {
            "name": "后三一码不定位",
            "prize": "7.21",
            "max_multiple": 55478,
            "display_prize": true
        },
        "52": {
            "name": "后三二码不定位",
            "prize": "36.20",
            "max_multiple": 11049,
            "display_prize": true
        },
        "53": {
            "name": "后三大小单双",
            "prize": "15.64",
            "max_multiple": 25575,
            "display_prize": true
        },
        "54": {
            "name": "和值尾数",
            "prize": "19.55",
            "max_multiple": 20460,
            "display_prize": true
        },
        "55": {
            "name": "后三趣味二星",
            "prize": "391.00",
            "max_multiple": 1023,
            "display_prize": true
        },
        "56": {
            "name": "后三区间二星",
            "prize": "977.50",
            "max_multiple": 409,
            "display_prize": true
        },
        "57": {
            "name": "特殊号码",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": false
        },
        "58": {
            "name": "后二大小单双",
            "prize": "7.82",
            "max_multiple": 51150,
            "display_prize": true
        },
        "59": {
            "name": "后二复式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "60": {
            "name": "直选跨度",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "61": {
            "name": "前二跨度",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "62": {
            "name": "直选跨度",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "63": {
            "name": "后二跨度",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "64": {
            "name": "包胆",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "65": {
            "name": "直选复式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "66": {
            "name": "前二复式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "67": {
            "name": "直选复式",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": true
        },
        "68": {
            "name": "直选复式",
            "prize": "195500.00",
            "max_multiple": 2,
            "display_prize": true
        },
        "69": {
            "name": "直选复式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "70": {
            "name": "后二复式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "71": {
            "name": "直选和值",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "72": {
            "name": "前二和值",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "73": {
            "name": "直选和值",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "74": {
            "name": "后二和值",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "75": {
            "name": "组选和值",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "76": {
            "name": "前二和值",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "77": {
            "name": "后二和值",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "78": {
            "name": "定位胆",
            "prize": "19.55",
            "max_multiple": 20460,
            "display_prize": true
        },
        "79": {
            "name": "直选组合",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": false
        },
        "80": {
            "name": "组选和值",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "81": {
            "name": "混合组选",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "82": {
            "name": "直选组合",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": false
        },
        "83": {
            "name": "包胆",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "84": {
            "name": "前二包胆",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "85": {
            "name": "后二包胆",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "142": {
            "name": "直选单式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "143": {
            "name": "组三单式",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "144": {
            "name": "组六单式",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "145": {
            "name": "组三",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "146": {
            "name": "组六",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "149": {
            "name": "直选跨度",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "150": {
            "name": "直选复式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "151": {
            "name": "直选和值",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "152": {
            "name": "混合组选",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "153": {
            "name": "包胆",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "154": {
            "name": "组选和值",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "155": {
            "name": "特殊号码",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": false
        },
        "156": {
            "name": "和值尾数",
            "prize": "19.55",
            "max_multiple": 20460,
            "display_prize": true
        },
        "184": {
            "name": "总和大小单双",
            "prize": "3.91",
            "max_multiple": 102301,
            "display_prize": true
        },
        "185": {
            "name": "龙虎和",
            "prize": "19.55",
            "max_multiple": 20460,
            "display_prize": false
        },
        "186": {
            "name": "直选复式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "187": {
            "name": "直选单式",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "188": {
            "name": "直选和值",
            "prize": "195.50",
            "max_multiple": 2046,
            "display_prize": true
        },
        "189": {
            "name": "直选复式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "190": {
            "name": "直选单式",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "191": {
            "name": "直选和值",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": true
        },
        "192": {
            "name": "直选复式",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": true
        },
        "193": {
            "name": "直选单式",
            "prize": "19550.00",
            "max_multiple": 20,
            "display_prize": true
        },
        "194": {
            "name": "组选4",
            "prize": "4887.50",
            "max_multiple": 81,
            "display_prize": true
        },
        "195": {
            "name": "组选6",
            "prize": "3258.33",
            "max_multiple": 122,
            "display_prize": true
        },
        "196": {
            "name": "组选12",
            "prize": "1629.17",
            "max_multiple": 245,
            "display_prize": true
        },
        "197": {
            "name": "组选24",
            "prize": "814.58",
            "max_multiple": 491,
            "display_prize": true
        },
        "198": {
            "name": "组三复式",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "199": {
            "name": "组三单式",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": true
        },
        "200": {
            "name": "组六复式",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "201": {
            "name": "组六单式",
            "prize": "325.83",
            "max_multiple": 1227,
            "display_prize": true
        },
        "202": {
            "name": "混合组选",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "203": {
            "name": "组选和值",
            "prize": "651.67",
            "max_multiple": 613,
            "display_prize": false
        },
        "204": {
            "name": "组选复式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "205": {
            "name": "组选单式",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "206": {
            "name": "组选和值",
            "prize": "97.75",
            "max_multiple": 4092,
            "display_prize": true
        },
        "513": {
            "name": "直选组合",
            "prize": "1955.00",
            "max_multiple": 204,
            "display_prize": false
        }
    },
    "uploadPath": "http://u.ds.com/bets/upload-bet-number",
    "jsPath": "/assets/js/game/ssc/",
    "submitUrl": "/assets/simulated/submit.php",
    "loaddataUrl": "/assets/simulated/ssc-data-load.php",
    "loadIssueUrl": "http://u.ds.com/buy/load-numbers/1",
    "traceMaxTimes": 120,
    "optionalPrizes": [
        {
            "prize_group": "1800",
            "rate": "0.0775"
        },
        {
            "prize_group": "1801",
            "rate": "0.0770"
        },
        {
            "prize_group": "1802",
            "rate": "0.0765"
        },
        {
            "prize_group": "1803",
            "rate": "0.0760"
        },
        {
            "prize_group": "1804",
            "rate": "0.0755"
        },
        {
            "prize_group": "1805",
            "rate": "0.0750"
        },
        {
            "prize_group": "1806",
            "rate": "0.0745"
        },
        {
            "prize_group": "1807",
            "rate": "0.0740"
        },
        {
            "prize_group": "1808",
            "rate": "0.0735"
        },
        {
            "prize_group": "1809",
            "rate": "0.0730"
        },
        {
            "prize_group": "1810",
            "rate": "0.0725"
        },
        {
            "prize_group": "1811",
            "rate": "0.0720"
        },
        {
            "prize_group": "1812",
            "rate": "0.0715"
        },
        {
            "prize_group": "1813",
            "rate": "0.0710"
        },
        {
            "prize_group": "1814",
            "rate": "0.0705"
        },
        {
            "prize_group": "1815",
            "rate": "0.0700"
        },
        {
            "prize_group": "1816",
            "rate": "0.0695"
        },
        {
            "prize_group": "1817",
            "rate": "0.0690"
        },
        {
            "prize_group": "1818",
            "rate": "0.0685"
        },
        {
            "prize_group": "1819",
            "rate": "0.0680"
        },
        {
            "prize_group": "1820",
            "rate": "0.0675"
        },
        {
            "prize_group": "1821",
            "rate": "0.0670"
        },
        {
            "prize_group": "1822",
            "rate": "0.0665"
        },
        {
            "prize_group": "1823",
            "rate": "0.0660"
        },
        {
            "prize_group": "1824",
            "rate": "0.0655"
        },
        {
            "prize_group": "1825",
            "rate": "0.0650"
        },
        {
            "prize_group": "1826",
            "rate": "0.0645"
        },
        {
            "prize_group": "1827",
            "rate": "0.0640"
        },
        {
            "prize_group": "1828",
            "rate": "0.0635"
        },
        {
            "prize_group": "1829",
            "rate": "0.0630"
        },
        {
            "prize_group": "1830",
            "rate": "0.0625"
        },
        {
            "prize_group": "1831",
            "rate": "0.0620"
        },
        {
            "prize_group": "1832",
            "rate": "0.0615"
        },
        {
            "prize_group": "1833",
            "rate": "0.0610"
        },
        {
            "prize_group": "1834",
            "rate": "0.0605"
        },
        {
            "prize_group": "1835",
            "rate": "0.0600"
        },
        {
            "prize_group": "1836",
            "rate": "0.0595"
        },
        {
            "prize_group": "1837",
            "rate": "0.0590"
        },
        {
            "prize_group": "1838",
            "rate": "0.0585"
        },
        {
            "prize_group": "1839",
            "rate": "0.0580"
        },
        {
            "prize_group": "1840",
            "rate": "0.0575"
        },
        {
            "prize_group": "1841",
            "rate": "0.0570"
        },
        {
            "prize_group": "1842",
            "rate": "0.0565"
        },
        {
            "prize_group": "1843",
            "rate": "0.0560"
        },
        {
            "prize_group": "1844",
            "rate": "0.0555"
        },
        {
            "prize_group": "1845",
            "rate": "0.0550"
        },
        {
            "prize_group": "1846",
            "rate": "0.0545"
        },
        {
            "prize_group": "1847",
            "rate": "0.0540"
        },
        {
            "prize_group": "1848",
            "rate": "0.0535"
        },
        {
            "prize_group": "1849",
            "rate": "0.0530"
        },
        {
            "prize_group": "1850",
            "rate": "0.0525"
        },
        {
            "prize_group": "1851",
            "rate": "0.0520"
        },
        {
            "prize_group": "1852",
            "rate": "0.0515"
        },
        {
            "prize_group": "1853",
            "rate": "0.0510"
        },
        {
            "prize_group": "1854",
            "rate": "0.0505"
        },
        {
            "prize_group": "1855",
            "rate": "0.0500"
        },
        {
            "prize_group": "1856",
            "rate": "0.0495"
        },
        {
            "prize_group": "1857",
            "rate": "0.0490"
        },
        {
            "prize_group": "1858",
            "rate": "0.0485"
        },
        {
            "prize_group": "1859",
            "rate": "0.0480"
        },
        {
            "prize_group": "1860",
            "rate": "0.0475"
        },
        {
            "prize_group": "1861",
            "rate": "0.0470"
        },
        {
            "prize_group": "1862",
            "rate": "0.0465"
        },
        {
            "prize_group": "1863",
            "rate": "0.0460"
        },
        {
            "prize_group": "1864",
            "rate": "0.0455"
        },
        {
            "prize_group": "1865",
            "rate": "0.0450"
        },
        {
            "prize_group": "1866",
            "rate": "0.0445"
        },
        {
            "prize_group": "1867",
            "rate": "0.0440"
        },
        {
            "prize_group": "1868",
            "rate": "0.0435"
        },
        {
            "prize_group": "1869",
            "rate": "0.0430"
        },
        {
            "prize_group": "1870",
            "rate": "0.0425"
        },
        {
            "prize_group": "1871",
            "rate": "0.0420"
        },
        {
            "prize_group": "1872",
            "rate": "0.0415"
        },
        {
            "prize_group": "1873",
            "rate": "0.0410"
        },
        {
            "prize_group": "1874",
            "rate": "0.0405"
        },
        {
            "prize_group": "1875",
            "rate": "0.0400"
        },
        {
            "prize_group": "1876",
            "rate": "0.0395"
        },
        {
            "prize_group": "1877",
            "rate": "0.0390"
        },
        {
            "prize_group": "1878",
            "rate": "0.0385"
        },
        {
            "prize_group": "1879",
            "rate": "0.0380"
        },
        {
            "prize_group": "1880",
            "rate": "0.0375"
        },
        {
            "prize_group": "1881",
            "rate": "0.0370"
        },
        {
            "prize_group": "1882",
            "rate": "0.0365"
        },
        {
            "prize_group": "1883",
            "rate": "0.0360"
        },
        {
            "prize_group": "1884",
            "rate": "0.0355"
        },
        {
            "prize_group": "1885",
            "rate": "0.0350"
        },
        {
            "prize_group": "1886",
            "rate": "0.0345"
        },
        {
            "prize_group": "1887",
            "rate": "0.0340"
        },
        {
            "prize_group": "1888",
            "rate": "0.0335"
        },
        {
            "prize_group": "1889",
            "rate": "0.0330"
        },
        {
            "prize_group": "1890",
            "rate": "0.0325"
        },
        {
            "prize_group": "1891",
            "rate": "0.0320"
        },
        {
            "prize_group": "1892",
            "rate": "0.0315"
        },
        {
            "prize_group": "1893",
            "rate": "0.0310"
        },
        {
            "prize_group": "1894",
            "rate": "0.0305"
        },
        {
            "prize_group": "1895",
            "rate": "0.0300"
        },
        {
            "prize_group": "1896",
            "rate": "0.0295"
        },
        {
            "prize_group": "1897",
            "rate": "0.0290"
        },
        {
            "prize_group": "1898",
            "rate": "0.0285"
        },
        {
            "prize_group": "1899",
            "rate": "0.0280"
        },
        {
            "prize_group": "1900",
            "rate": "0.0275"
        },
        {
            "prize_group": "1901",
            "rate": "0.0270"
        },
        {
            "prize_group": "1902",
            "rate": "0.0265"
        },
        {
            "prize_group": "1903",
            "rate": "0.0260"
        },
        {
            "prize_group": "1904",
            "rate": "0.0255"
        },
        {
            "prize_group": "1905",
            "rate": "0.0250"
        },
        {
            "prize_group": "1906",
            "rate": "0.0245"
        },
        {
            "prize_group": "1907",
            "rate": "0.0240"
        },
        {
            "prize_group": "1908",
            "rate": "0.0235"
        },
        {
            "prize_group": "1909",
            "rate": "0.0230"
        },
        {
            "prize_group": "1910",
            "rate": "0.0225"
        },
        {
            "prize_group": "1911",
            "rate": "0.0220"
        },
        {
            "prize_group": "1912",
            "rate": "0.0215"
        },
        {
            "prize_group": "1913",
            "rate": "0.0210"
        },
        {
            "prize_group": "1914",
            "rate": "0.0205"
        },
        {
            "prize_group": "1915",
            "rate": "0.0200"
        },
        {
            "prize_group": "1916",
            "rate": "0.0195"
        },
        {
            "prize_group": "1917",
            "rate": "0.0190"
        },
        {
            "prize_group": "1918",
            "rate": "0.0185"
        },
        {
            "prize_group": "1919",
            "rate": "0.0180"
        },
        {
            "prize_group": "1920",
            "rate": "0.0175"
        },
        {
            "prize_group": "1921",
            "rate": "0.0170"
        },
        {
            "prize_group": "1922",
            "rate": "0.0165"
        },
        {
            "prize_group": "1923",
            "rate": "0.0160"
        },
        {
            "prize_group": "1924",
            "rate": "0.0155"
        },
        {
            "prize_group": "1925",
            "rate": "0.0150"
        },
        {
            "prize_group": "1926",
            "rate": "0.0145"
        },
        {
            "prize_group": "1927",
            "rate": "0.0140"
        },
        {
            "prize_group": "1928",
            "rate": "0.0135"
        },
        {
            "prize_group": "1929",
            "rate": "0.0130"
        },
        {
            "prize_group": "1930",
            "rate": "0.0125"
        },
        {
            "prize_group": "1931",
            "rate": "0.0120"
        },
        {
            "prize_group": "1932",
            "rate": "0.0115"
        },
        {
            "prize_group": "1933",
            "rate": "0.0110"
        },
        {
            "prize_group": "1934",
            "rate": "0.0105"
        },
        {
            "prize_group": "1935",
            "rate": "0.0100"
        },
        {
            "prize_group": "1936",
            "rate": "0.0095"
        },
        {
            "prize_group": "1937",
            "rate": "0.0090"
        },
        {
            "prize_group": "1938",
            "rate": "0.0085"
        },
        {
            "prize_group": "1939",
            "rate": "0.0080"
        },
        {
            "prize_group": "1940",
            "rate": "0.0075"
        },
        {
            "prize_group": "1941",
            "rate": "0.0070"
        },
        {
            "prize_group": "1942",
            "rate": "0.0065"
        },
        {
            "prize_group": "1943",
            "rate": "0.0060"
        },
        {
            "prize_group": "1944",
            "rate": "0.0055"
        },
        {
            "prize_group": "1945",
            "rate": "0.0050"
        },
        {
            "prize_group": "1946",
            "rate": "0.0045"
        },
        {
            "prize_group": "1947",
            "rate": "0.0040"
        },
        {
            "prize_group": "1948",
            "rate": "0.0035"
        },
        {
            "prize_group": "1949",
            "rate": "0.0030"
        },
        {
            "prize_group": "1950",
            "rate": "0.0025"
        },
        {
            "prize_group": "1951",
            "rate": "0.0020"
        },
        {
            "prize_group": "1952",
            "rate": "0.0015"
        },
        {
            "prize_group": "1953",
            "rate": "0.0010"
        },
        {
            "prize_group": "1954",
            "rate": "0.0005"
        },
        {
            "prize_group": "1955",
            "rate": "0.0000"
        }
    ],
    "gameNumbers": [
        {
            "number": "151111057",
            "time": "2015-11-11 15:29:40"
        },
        {
            "number": "151111058",
            "time": "2015-11-11 15:39:40"
        },
        {
            "number": "151111059",
            "time": "2015-11-11 15:49:40"
        },
        {
            "number": "151111060",
            "time": "2015-11-11 15:59:40"
        },
        {
            "number": "151111061",
            "time": "2015-11-11 16:09:40"
        },
        {
            "number": "151111062",
            "time": "2015-11-11 16:19:40"
        },
        {
            "number": "151111063",
            "time": "2015-11-11 16:29:40"
        },
        {
            "number": "151111064",
            "time": "2015-11-11 16:39:40"
        },
        {
            "number": "151111065",
            "time": "2015-11-11 16:49:40"
        },
        {
            "number": "151111066",
            "time": "2015-11-11 16:59:40"
        },
        {
            "number": "151111067",
            "time": "2015-11-11 17:09:40"
        },
        {
            "number": "151111068",
            "time": "2015-11-11 17:19:40"
        },
        {
            "number": "151111069",
            "time": "2015-11-11 17:29:40"
        },
        {
            "number": "151111070",
            "time": "2015-11-11 17:39:40"
        },
        {
            "number": "151111071",
            "time": "2015-11-11 17:49:40"
        },
        {
            "number": "151111072",
            "time": "2015-11-11 17:59:40"
        },
        {
            "number": "151111073",
            "time": "2015-11-11 18:09:40"
        },
        {
            "number": "151111074",
            "time": "2015-11-11 18:19:40"
        },
        {
            "number": "151111075",
            "time": "2015-11-11 18:29:40"
        },
        {
            "number": "151111076",
            "time": "2015-11-11 18:39:40"
        },
        {
            "number": "151111077",
            "time": "2015-11-11 18:49:40"
        },
        {
            "number": "151111078",
            "time": "2015-11-11 18:59:40"
        },
        {
            "number": "151111079",
            "time": "2015-11-11 19:09:40"
        },
        {
            "number": "151111080",
            "time": "2015-11-11 19:19:40"
        },
        {
            "number": "151111081",
            "time": "2015-11-11 19:29:40"
        },
        {
            "number": "151111082",
            "time": "2015-11-11 19:39:40"
        },
        {
            "number": "151111083",
            "time": "2015-11-11 19:49:40"
        },
        {
            "number": "151111084",
            "time": "2015-11-11 19:59:40"
        },
        {
            "number": "151111085",
            "time": "2015-11-11 20:09:40"
        },
        {
            "number": "151111086",
            "time": "2015-11-11 20:19:40"
        },
        {
            "number": "151111087",
            "time": "2015-11-11 20:29:40"
        },
        {
            "number": "151111088",
            "time": "2015-11-11 20:39:40"
        },
        {
            "number": "151111089",
            "time": "2015-11-11 20:49:40"
        },
        {
            "number": "151111090",
            "time": "2015-11-11 20:59:40"
        },
        {
            "number": "151111091",
            "time": "2015-11-11 21:09:40"
        },
        {
            "number": "151111092",
            "time": "2015-11-11 21:19:40"
        },
        {
            "number": "151111093",
            "time": "2015-11-11 21:29:40"
        },
        {
            "number": "151111094",
            "time": "2015-11-11 21:39:40"
        },
        {
            "number": "151111095",
            "time": "2015-11-11 21:49:40"
        },
        {
            "number": "151111096",
            "time": "2015-11-11 21:59:40"
        },
        {
            "number": "151111097",
            "time": "2015-11-11 22:04:55"
        },
        {
            "number": "151111098",
            "time": "2015-11-11 22:09:55"
        },
        {
            "number": "151111099",
            "time": "2015-11-11 22:14:55"
        },
        {
            "number": "151111100",
            "time": "2015-11-11 22:19:55"
        },
        {
            "number": "151111101",
            "time": "2015-11-11 22:24:55"
        },
        {
            "number": "151111102",
            "time": "2015-11-11 22:29:55"
        },
        {
            "number": "151111103",
            "time": "2015-11-11 22:34:55"
        },
        {
            "number": "151111104",
            "time": "2015-11-11 22:39:55"
        },
        {
            "number": "151111105",
            "time": "2015-11-11 22:44:55"
        },
        {
            "number": "151111106",
            "time": "2015-11-11 22:49:55"
        },
        {
            "number": "151111107",
            "time": "2015-11-11 22:54:55"
        },
        {
            "number": "151111108",
            "time": "2015-11-11 22:59:55"
        },
        {
            "number": "151111109",
            "time": "2015-11-11 23:04:55"
        },
        {
            "number": "151111110",
            "time": "2015-11-11 23:09:55"
        },
        {
            "number": "151111111",
            "time": "2015-11-11 23:14:55"
        },
        {
            "number": "151111112",
            "time": "2015-11-11 23:19:55"
        },
        {
            "number": "151111113",
            "time": "2015-11-11 23:24:55"
        },
        {
            "number": "151111114",
            "time": "2015-11-11 23:29:55"
        },
        {
            "number": "151111115",
            "time": "2015-11-11 23:34:55"
        },
        {
            "number": "151111116",
            "time": "2015-11-11 23:39:55"
        },
        {
            "number": "151111117",
            "time": "2015-11-11 23:44:55"
        },
        {
            "number": "151111118",
            "time": "2015-11-11 23:49:55"
        },
        {
            "number": "151111119",
            "time": "2015-11-11 23:54:55"
        },
        {
            "number": "151111120",
            "time": "2015-11-11 23:59:55"
        },
        {
            "number": "151112001",
            "time": "2015-11-12 00:04:55"
        },
        {
            "number": "151112002",
            "time": "2015-11-12 00:09:55"
        },
        {
            "number": "151112003",
            "time": "2015-11-12 00:14:55"
        },
        {
            "number": "151112004",
            "time": "2015-11-12 00:19:55"
        },
        {
            "number": "151112005",
            "time": "2015-11-12 00:24:55"
        },
        {
            "number": "151112006",
            "time": "2015-11-12 00:29:55"
        },
        {
            "number": "151112007",
            "time": "2015-11-12 00:34:55"
        },
        {
            "number": "151112008",
            "time": "2015-11-12 00:39:55"
        },
        {
            "number": "151112009",
            "time": "2015-11-12 00:44:55"
        },
        {
            "number": "151112010",
            "time": "2015-11-12 00:49:55"
        },
        {
            "number": "151112011",
            "time": "2015-11-12 00:54:55"
        },
        {
            "number": "151112012",
            "time": "2015-11-12 00:59:55"
        },
        {
            "number": "151112013",
            "time": "2015-11-12 01:04:55"
        },
        {
            "number": "151112014",
            "time": "2015-11-12 01:09:55"
        },
        {
            "number": "151112015",
            "time": "2015-11-12 01:14:55"
        },
        {
            "number": "151112016",
            "time": "2015-11-12 01:19:55"
        },
        {
            "number": "151112017",
            "time": "2015-11-12 01:24:55"
        },
        {
            "number": "151112018",
            "time": "2015-11-12 01:29:55"
        },
        {
            "number": "151112019",
            "time": "2015-11-12 01:34:55"
        },
        {
            "number": "151112020",
            "time": "2015-11-12 01:39:55"
        },
        {
            "number": "151112021",
            "time": "2015-11-12 01:44:55"
        },
        {
            "number": "151112022",
            "time": "2015-11-12 01:49:55"
        },
        {
            "number": "151112023",
            "time": "2015-11-12 01:54:55"
        },
        {
            "number": "151112024",
            "time": "2015-11-12 09:59:40"
        },
        {
            "number": "151112025",
            "time": "2015-11-12 10:09:40"
        },
        {
            "number": "151112026",
            "time": "2015-11-12 10:19:40"
        },
        {
            "number": "151112027",
            "time": "2015-11-12 10:29:40"
        },
        {
            "number": "151112028",
            "time": "2015-11-12 10:39:40"
        },
        {
            "number": "151112029",
            "time": "2015-11-12 10:49:40"
        },
        {
            "number": "151112030",
            "time": "2015-11-12 10:59:40"
        },
        {
            "number": "151112031",
            "time": "2015-11-12 11:09:40"
        },
        {
            "number": "151112032",
            "time": "2015-11-12 11:19:40"
        },
        {
            "number": "151112033",
            "time": "2015-11-12 11:29:40"
        },
        {
            "number": "151112034",
            "time": "2015-11-12 11:39:40"
        },
        {
            "number": "151112035",
            "time": "2015-11-12 11:49:40"
        },
        {
            "number": "151112036",
            "time": "2015-11-12 11:59:40"
        },
        {
            "number": "151112037",
            "time": "2015-11-12 12:09:40"
        },
        {
            "number": "151112038",
            "time": "2015-11-12 12:19:40"
        },
        {
            "number": "151112039",
            "time": "2015-11-12 12:29:40"
        },
        {
            "number": "151112040",
            "time": "2015-11-12 12:39:40"
        },
        {
            "number": "151112041",
            "time": "2015-11-12 12:49:40"
        },
        {
            "number": "151112042",
            "time": "2015-11-12 12:59:40"
        },
        {
            "number": "151112043",
            "time": "2015-11-12 13:09:40"
        },
        {
            "number": "151112044",
            "time": "2015-11-12 13:19:40"
        },
        {
            "number": "151112045",
            "time": "2015-11-12 13:29:40"
        },
        {
            "number": "151112046",
            "time": "2015-11-12 13:39:40"
        },
        {
            "number": "151112047",
            "time": "2015-11-12 13:49:40"
        },
        {
            "number": "151112048",
            "time": "2015-11-12 13:59:40"
        },
        {
            "number": "151112049",
            "time": "2015-11-12 14:09:40"
        },
        {
            "number": "151112050",
            "time": "2015-11-12 14:19:40"
        },
        {
            "number": "151112051",
            "time": "2015-11-12 14:29:40"
        },
        {
            "number": "151112052",
            "time": "2015-11-12 14:39:40"
        },
        {
            "number": "151112053",
            "time": "2015-11-12 14:49:40"
        },
        {
            "number": "151112054",
            "time": "2015-11-12 14:59:40"
        },
        {
            "number": "151112055",
            "time": "2015-11-12 15:09:40"
        },
        {
            "number": "151112056",
            "time": "2015-11-12 15:19:40"
        }
    ],
    "currentNumber": "151111057",
    "currentNumberTime": 1447226980,
    "currentTime": 1447226785,
    "availableCoefficients": {
        "1.000": "2元",
        "0.500": "1元",
        "0.100": "2角",
        "0.050": "1角",
        "0.010": "2分",
        "0.001": "2厘"
    },
    "defaultMultiple": "1",
    "defaultCoefficient": "1.000",
    "prizeLimit": "400000",
    "maxPrizeGroup": "1950",
    "_token": "UrqBRQuRDBnU2WPKjrre9sb6hIeMo025ObELuY3d",
    "issueHistory": {
        "issues": [
            {
                "issue": "151106062",
                "wn_number": "",
                "offical_time": "1446798000"
            },
            {
                "issue": "151106061",
                "wn_number": "",
                "offical_time": "1446797400"
            },
            {
                "issue": "151106060",
                "wn_number": "",
                "offical_time": "1446796800"
            },
            {
                "issue": "151106059",
                "wn_number": "",
                "offical_time": "1446796200"
            },
            {
                "issue": "151106058",
                "wn_number": "",
                "offical_time": "1446795600"
            },
            {
                "issue": "151106057",
                "wn_number": "",
                "offical_time": "1446795000"
            },
            {
                "issue": "151106056",
                "wn_number": "",
                "offical_time": "1446794400"
            },
            {
                "issue": "151106055",
                "wn_number": "",
                "offical_time": "1446793800"
            },
            {
                "issue": "151106054",
                "wn_number": "",
                "offical_time": "1446793200"
            },
            {
                "issue": "151106053",
                "wn_number": "",
                "offical_time": "1446792600"
            }
        ],
        "last_number": {
            "issue": "151101023",
            "wn_number": "79392",
            "offical_time": "1446314100"
        },
        "current_issue": "151111057"
    }
}