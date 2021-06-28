#! coding=utf-8
'''
解析网页中的符文之语描述信息，将描述信息保存到 MySQL 中

网页要先下载好，放到当前目录下，使用时通过 -f 参数传入网页的名字。
数据库名字为 scstat，表名字为 rune_word。

requirements:
    pip install beautifulsoup4 PyMySQL
'''

import getopt, sys, os, re
import pymysql
from bs4 import BeautifulSoup

DB = 'scstat'
TABLE = 'rune_word'
USER = 'root'
PASS = '1801'

def _usage():
    print('usage: {} -f "html filename" [-u username] [-p password]'.format(sys.argv[0]))
    sys.exit(1)

def _findName(table):
    """在 table 代表的内容中进行正则匹配，找到对应的符文之语英文名字

    典型名字所在位置左右信息为：<br/>Lionheart</span>，其中 Lionheart 就是英文名
    """
    # print(type(table))
    result = re.search(r'<br/>(.*?)</span>', table)
    if result:
        return result.group(1)
    else:
        return None


def _parseHtml(filename):
    """根据用户输入的文件名字，找到名字对应 HTML 文件的绝对路径

    Args:
        filename, string, 文件名字，不包含路径。HTML 文件就在脚本当前目录下，后缀为 html

    Returns:
        dict, 符文之语名字到符文之语内容的映射表
    """
    limit = None
    with open(filename) as fp:
        # 将所有结果存入映射表
        contentMap = {}
        soup = BeautifulSoup(fp, 'html.parser')
        data = soup.find_all(style='background:#000; border: 1px solid #2F0600; text-align: center;', limit=limit)
        for table in data:
            # table 是 bs4.element.Tag 类型
            tableString = str(table)
            name = _findName(tableString)
            if name:
                contentMap[name] = tableString

    # print(contentMap)
    return contentMap


def _writeToDb(maps):
    """将解析出的符文之语描述信息填充到符文之语信息文件中
    Args:
        maps, dict, key 为符文之语的英文名，value 为符文之语描述信息
    Returns:
        void
    
    FIXME:
        下面的 SQL 语句中，直接写表名字没问题，无论是否加上两头的 `` 符号；只要如下形式：
            cursor.execute("SELECT `id` FROM %s WHERE `name`=%s", (TABLE, name))
        通过参数将表名字传入 execute() 函数，就会提示找不到 "scstat.'rune_word' 表，也就是会自动给表名字加上数据库前缀，然后就找不到了。
    """
    # print(maps)
    db = pymysql.connect(host='127.0.0.1', user=USER, password=PASS, database=DB, cursorclass=pymysql.cursors.DictCursor)
    cursor = db.cursor()
    
    count = 0
    for name in maps:
        sql = "SELECT `id` FROM {} WHERE `name`=%s".format(TABLE)
        cursor.execute(sql, (name,))
        result = cursor.fetchone()
        if result != None:
            sql = "UPDATE {} SET `html`=%s WHERE `id`=%s".format(TABLE)
            ret = cursor.execute(sql, (maps[name], result['id']))
            count = count + 1

    print("total {} records updated".format(count))
    db.commit()


def _parseAll():
    """解析所有预先下载好的附文之语页面
    """
    files = ['Body Armor Rune Words.html', 'Helm Rune Words.html', 'Shield Rune Words.html', 'Weapon Rune Words.html']
    for filename in files:
        maps = _parseHtml(filename)
        _writeToDb(maps)

def main():
    try:
        global USER, PASS
        filename = None

        opts, args = getopt.getopt(sys.argv[1:], 'f:u:p:')
        for opt, arg in opts:
            if opt == '-f':
                filename = arg
            elif opt == '-u':
                USER = arg
            elif opt == '-p':
                PASS = arg

        if filename:
            maps = _parseHtml(filename)
            _writeToDb(maps)
        else:
            _parseAll()
            # _usage()

    except getopt.GetoptError:
        _usage()


main()