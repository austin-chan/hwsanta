//
//  SantaChatViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/7/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SantaChatViewController.h"
#import <QuartzCore/QuartzCore.h>
#import <UIKit/UIKit.h>
#import "GameState.h"

@interface SantaChatViewController (){
    NSInteger currentHeight;
    BOOL isRequesting;
    
    NSMutableData *responseRefresh;
    NSMutableData *responseMessage;
    
    NSURLConnection *connectionRefresh;
    NSURLConnection *connectionMessage;
}

@end

@implementation SantaChatViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}


- (void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    [self refresh:nil];
    
    self.tabBarController.title = @"Chat with your Santa";
    
    UIBarButtonItem *item = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemRefresh target:self action:@selector(refresh:)];
    
    self.tabBarController.navigationItem.rightBarButtonItem = item;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    self.scrollView.alwaysBounceVertical = YES;
    
    [self prepTheBackground];
    [self prepTheButton];
    
    [NSTimer scheduledTimerWithTimeInterval:5.0
                                     target:self
                                   selector:@selector(refresh:)
                                   userInfo:nil
                                    repeats:YES];
    
    // Do any additional setup after loading the view.
}



- (void)loadChatWithLog:(NSArray *)log{
    [self clearChat];
    for(int x = 0; x < [log count]; x ++){
        NSArray *entry = [log objectAtIndex:x];
        
        NSString *title = [entry objectAtIndex:0];
        NSString *message = [entry objectAtIndex:1];
        
        if([title isEqualToString:@"You"]){
            [self addChatBubbleForYou:message];
        }else{
            [self addChatBubbleForYourSanta:message withName:title];
        }
    }
    self.scrollView.contentSize = CGSizeMake(320, currentHeight);
    self.scrollView.contentOffset = CGPointMake(0, MAX(0, currentHeight - self.scrollView.frame.size.height));

    [self.activity stopAnimating];

}

- (void)prepTheBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"debut_light.png"]];
    self.view.backgroundColor = backgroundColor;
}
- (void)prepTheButton{
    UIImage *image = [[UIImage imageNamed:@"blackButton.png"]
                      resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *imageHighlight = [[UIImage imageNamed:@"blackButtonHighlight.png"]
                               resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    // Set the background for any states you plan to use
    [self.messageButton setBackgroundImage:image forState:UIControlStateNormal];
    [self.messageButton setBackgroundImage:imageHighlight forState:UIControlStateHighlighted];
}

- (void)clearChat{
    for(UIView *subview in [self.scrollView subviews]) {
        [subview removeFromSuperview];
    }
    currentHeight = 0;
}

- (void)addChatBubbleForYourSanta:(NSString *)bubbleText withName:(NSString *)name{
    [self addBubbleText:bubbleText withColor:[UIColor colorWithRed:232/255.0 green:178/255.0 blue:179/255.0 alpha:1] forPerson:name];
    
}
- (void)addChatBubbleForYou:(NSString *)bubbleText{
    [self addBubbleText:bubbleText withColor:[UIColor colorWithRed:209/255.0 green:209/255.0 blue:209/255.0 alpha:1] forPerson:@"You:"];
    
}
- (void)addBubbleText:(NSString *)bubbleText withColor:(UIColor *)color forPerson:(NSString *)person{
    CGSize maxSize = CGSizeMake(320, 9999); // 999 can be any maxmimum height you want
    UIFont *aFont = [UIFont fontWithName:@"HelveticaNeue-Light" size:16];
    
    CGSize newSize = [bubbleText sizeWithFont:aFont constrainedToSize:maxSize lineBreakMode:NSLineBreakByWordWrapping];
    NSInteger height = newSize.height;
    UITextView *textView = [[UITextView alloc] init];
    textView.editable=NO;
    textView.font = aFont;
    textView.text = bubbleText;
    textView.backgroundColor = [UIColor clearColor];
    textView.frame = CGRectMake(10, 25, 310, height+20);
    textView.scrollEnabled = NO;
    
    UIView *wrapView = [[UIView alloc] initWithFrame: CGRectMake(0, currentHeight, 320, height+45)];
    [wrapView addSubview:textView];
    wrapView.backgroundColor = color;
    
    currentHeight += height + 45;
    
    UILabel *label = [[UILabel alloc] init];
    label.text = person;
    label.font = [UIFont fontWithName:@"HelveticaNeue-Bold" size:16];
    label.backgroundColor = [UIColor clearColor];
    label.frame = CGRectMake(17, 10, 150, 20);
    [wrapView addSubview:label];
    
    // Add darkGray bottom
    CALayer *bottomBorder = [CALayer layer];
    bottomBorder.borderColor = [UIColor darkGrayColor].CGColor;
    bottomBorder.borderWidth = 1;
    bottomBorder.frame = CGRectMake(-1, -1, wrapView.frame.size.width+2, wrapView.frame.size.height + 1);
    
    // Add white top
    CALayer *topBorder = [CALayer layer];
    topBorder.borderColor = [UIColor lightGrayColor].CGColor;
    topBorder.borderWidth = .5;
    topBorder.frame = CGRectMake(-1, 0, wrapView.frame.size.width+2, wrapView.frame.size.height);
    
    [wrapView.layer addSublayer:bottomBorder];
    [wrapView.layer addSublayer:topBorder];
    [self.scrollView addSubview:wrapView];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)refresh:(NSObject *)obj{
    if(isRequesting) return;
    
    isRequesting = YES;
    [self.activity startAnimating];
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/home/chatsanta.php?userid=%@", [[GameState sharedGameState] getUserID]];
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    connectionRefresh = [[NSURLConnection alloc] initWithRequest:request delegate:self];
}

- (IBAction)sendMessage:(id)sender {
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"New Message" message:nil delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"Send", nil];
    [alert setAlertViewStyle:UIAlertViewStylePlainTextInput];
    [alert show];
}

- (void) alertView:(UIAlertView *)alert clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if(buttonIndex==0){
        NSLog(@"Cancel");
    }else{
        NSString *message = [[alert textFieldAtIndex:0] text];

        NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/home/messagesanta.php?userid=%@&message=%@", [[GameState sharedGameState] getUserID], [message stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding] ];
        NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:sendString]];
        
        connectionMessage = [[NSURLConnection alloc] initWithRequest:request delegate:self];
    }
}




- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    if(connection == connectionRefresh) {
        responseRefresh = [[NSMutableData alloc] init];
    }else{
        responseMessage = [[NSMutableData alloc] init];
    }
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    if(connection == connectionRefresh) {
        [responseRefresh appendData:data];
    }else{
        [responseMessage appendData:data];
    }
}
- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    isRequesting = NO;
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    NSLog(@"%@", error);
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    isRequesting = NO;
    NSError *error;
    if(connection == connectionRefresh) {
        NSArray *arr = [NSJSONSerialization JSONObjectWithData:responseRefresh options:NSASCIIStringEncoding error:&error];
        [self loadChatWithLog:arr];
        NSLog(@"%@", arr);
    }else{
        NSString *str = [[NSString alloc] initWithData:responseMessage encoding:NSASCIIStringEncoding];
        if([str isEqualToString:@"empty"]){
            [[[UIAlertView alloc] initWithTitle:@"No Santa Yet" message:@"Sorry, you don't have a Santa yet. You will be given one soon." delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
        }
        [self refresh:nil];
    
    }

    
}
@end
